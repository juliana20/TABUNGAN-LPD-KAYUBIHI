<?php

namespace App\Http\Controllers;

use App\Http\Model\Pegawai_m;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\User_m;
use Illuminate\Http\Request;
use App\Http\Model\Validasi_setoran_m;
use Validator;
use DataTables;
use DB;
use Response;
use Helpers;

class ValidasiSetoranController extends Controller
{
    protected $model;
    public function __construct(Validasi_setoran_m $model)
    {
        $this->model = $model;
        $this->nameroutes = 'validasi-setoran';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Validasi Setoran',
            'header'            => 'Data Validasi Setoran',
            'breadcrumb'        => 'List Data Validasi Setoran',
            'urlDatatables'     => "{$this->nameroutes}/datatables",
            'idDatatables'      => 'dt_validasi_setoran'
        );
        return view('validasi_setoran.datatable', $data);
    }

    public function create(Request $request)
    {
        $item = [
            'tanggal' => date('Y-m-d'),
            'tanggal_setoran' => date('Y-m-d')
        ];
        $data = array(
            'title'             => 'Validasi Setoran',
            'header'            => 'Validasi Setoran',
            'item'              => (object) $item,
            'submit_url'        => url()->current(),
            'is_edit'           => FALSE,
            'nameroutes'        => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['user_id'] = Helpers::getId();
            $details = $request->input('details');

            if (empty($details)) {
                $response = [
                    'message' => 'Daftar setoran kosong',
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            $validator = Validator::make( $header, $this->model->rules['insert']);
            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

            DB::beginTransaction();
            try {
                $this->model->insert_data($header);
                foreach($details as $row)
                {
                    if($row['setoran'] == 1)
                    {
                        Simpan_tabungan_m::where('id', $row['id'])->update(['validasi' =>  1]);
                    }elseif($row['penarikan'] == 1)
                    {
                        Tarik_tabungan_m::where('id', $row['id'])->update(['validasi' =>  1]);
                    }
                    
                }
                DB::commit();
    
                $response = [
                    "message" => 'Validasi setoran tersimpan',
                    'status' => 'success',
                    'code' => 200,
                ];
    
            } catch (\Exception $e) {
                DB::rollback();
                $response = [
                    "message" => $e->getMessage(),
                    'status' => 'error',
                    'code' => 500,
                    
                ];
            }
    
            return Response::json($response);
        }

        return view('validasi_setoran.form', $data);

    }

    public function getDetail(Request $request)
    {
        $params = $request->all();
        $get_user = Pegawai_m::join('m_user','m_user.id','m_pegawai.user_id')
                    ->where('m_pegawai.id', $params['kolektor_id'])
                    ->first();

        $setoran = Simpan_tabungan_m::join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                        ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                        ->select(
                        't_simpan_tabungan.*',
                        'm_tabungan.no_rekening',
                        'm_nasabah.nama_nasabah'
                    )
                    ->where([
                        't_simpan_tabungan.tanggal' => $params['tanggal_setoran'],
                        't_simpan_tabungan.user_id' =>  $get_user->id,
                        't_simpan_tabungan.validasi' =>  0
                    ])
                    ->addSelect(
                        \DB::raw("'0' as nominal_penarikan"),
                        \DB::raw("'1' as setoran"),
                        \DB::raw("'0' as penarikan")
                    )
                    ->get();

        $penarikan = Tarik_tabungan_m::join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                        ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                        ->select(
                        't_tarik_tabungan.*',
                        'm_tabungan.no_rekening',
                        'm_nasabah.nama_nasabah'
                    )
                    ->where([
                        't_tarik_tabungan.tanggal' => $params['tanggal_setoran'],
                        't_tarik_tabungan.user_id' =>  $get_user->id,
                        't_tarik_tabungan.validasi' =>  0
                    ])
                    ->addSelect(
                        \DB::raw("'0' as nominal_setoran"),
                        \DB::raw("'0' as setoran"),
                        \DB::raw("'1' as penarikan")

                    )
                    ->get();

        $collection = collect(array_merge($setoran->toArray(), $penarikan->toArray()))->sortby('tanggal');
        return response()->json([
            'success' => true,
            'data'    => $collection,
        ]);
    }

    public function delete($id)
    {
        $get_item = Validasi_setoran_m::where('id', $id)->first();
        $get_user = Pegawai_m::join('m_user','m_user.id','m_pegawai.user_id')
                    ->where('m_pegawai.id', $get_item->kolektor_id)
                    ->select('m_user.*')
                    ->first();

        DB::beginTransaction();
        try {
            #cek sudah digunakan
            $get_setoran = Simpan_tabungan_m::where([
                'tanggal' => $get_item->tanggal_setoran,
                'user_id' => $get_user->id
            ])->get();

            $get_penarikan = Tarik_tabungan_m::where([
                'tanggal' => $get_item->tanggal_setoran,
                'user_id' => $get_user->id
            ])->get();

            if(!empty($get_setoran))
            {
                foreach($get_setoran as $row)
                {
                    Simpan_tabungan_m::where('id', $row->id)->update(['validasi' => 0]);
                }

            }
            if(!empty($get_penarikan))
            {
                foreach($get_penarikan as $row)
                {
                    Tarik_tabungan_m::where('id', $row->id)->update(['validasi' => 0]);
                }

            }
            Validasi_setoran_m::where('id', $id)->delete();
            DB::commit();

            $response = [
                "message" => 'Validasi setoran berhasil dibatalkan',
                'status' => 'success',
                'code' => 200,
            ];
       
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "message" => $e->getMessage(),
                'status' => 'error',
                'code' => 500,
                
            ];
        }
        return Response::json($response); 
    }


    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }


}
