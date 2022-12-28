<?php

namespace App\Http\Controllers;

use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\Tutup_buku_m;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use DB;
use Response;
use Helpers;

class TutupBukuController extends Controller
{
    protected $model;
    public function __construct(Tutup_buku_m $model)
    {
        $this->model = $model;
        $this->nameroutes = 'tutup-buku';
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
            'title'             => 'Tutup Buku',
            'header'            => 'Tutup Buku',
            'breadcrumb'        => 'Tutup Buku',
            'urlDatatables'     => "{$this->nameroutes}/datatables",
            'idDatatables'      => 'dt_tutup_buku'
        );
        return view('tutup_buku.datatable', $data);
    }

    public function create(Request $request)
    {
        $item = [
            'tanggal' => date('Y-m-d')
        ];
        $data = array(
            'title'             => 'Tutup Buku',
            'header'            => 'Tutup Buku',
            'item'              => (object) $item,
            'submit_url'        => url()->current(),
            'is_edit'           => FALSE,
            'nameroutes'        => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $cek_tutup_buku = Tutup_buku_m::where('tanggal', $header['tanggal'])->first();
            if(!empty($cek_tutup_buku))
            {
                $response = [
                    'success' => false,
                    'message' => "Tutup buku sudah dilakukan pada tanggal $cek_tutup_buku->tanggal",
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            // if($header['tanggal'] > date('Y-m-d'))
            // {
            //     $response = [
            //         'success' => false,
            //         'message' => "Tutup buku tidak dapat dilakukan karena tanggal tidak sesuai",
            //         'status' => 'error',
            //         'code' => 500,
            //     ];
            //     return Response::json($response);
            // }
            $header['user_id'] = Helpers::getId();
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
                $get_setoran = Simpan_tabungan_m::where('tutup_buku', 0)->whereDate('tanggal', '=', $header['tanggal'])->get();
                $get_penarikan = Tarik_tabungan_m::where('tutup_buku', 0)->whereDate('tanggal', '=', $header['tanggal'])->get();
    
                if(!empty($get_setoran))
                {
                    foreach($get_setoran as $row)
                    {
                        Simpan_tabungan_m::where('id', $row->id)->update(['tutup_buku' => 1]);
                    }
    
                }
                if(!empty($get_penarikan))
                {
                    foreach($get_penarikan as $row)
                    {
                        Tarik_tabungan_m::where('id', $row->id)->update(['tutup_buku' => 1]);
                    }
    
                }
                $this->model->insert_data($header);
                DB::commit();
    
                $response = [
                    "message" => 'Proses tutup buku berhasil',
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

        return view('tutup_buku.form', $data);

    }

    public function getDetail(Request $request)
    {
        $params = $request->all();
        $total_setoran = Simpan_tabungan_m::where('tutup_buku', 0)->whereDate('tanggal', '=', $params['tanggal'])->sum('nominal_setoran');
        $total_penarikan = Tarik_tabungan_m::where('tutup_buku', 0)->whereDate('tanggal', '=', $params['tanggal'])->sum('nominal_penarikan');

        return response()->json([
            'success' => true,
            'total_setoran' => $total_setoran,
            'total_penarikan' => $total_penarikan
        ]);
    }

    public function delete($id)
    {
        $get_item = Tutup_buku_m::where('id', $id)->first();
        // $date_min = Tutup_buku_m::whereDate('tanggal', '<', $get_item->tanggal)->first();
        // if(!empty($date_min))
        // {
        //     $get_setoran = Simpan_tabungan_m::whereBetween('tanggal',[$date_min->tanggal, $get_item->tanggal])->get();
        //     $get_penarikan = Tarik_tabungan_m::whereBetween('tanggal',[$date_min->tanggal, $get_item->tanggal])->get();
        // }
        // else{
        //     $get_setoran = Simpan_tabungan_m::whereDate('tanggal', '<=', $get_item->tanggal)->get();
        //     $get_penarikan = Tarik_tabungan_m::whereDate('tanggal', '<=', $get_item->tanggal)->get();
        // }
        $get_setoran = Simpan_tabungan_m::whereDate('tanggal', '=', $get_item->tanggal)->get();
        $get_penarikan = Tarik_tabungan_m::whereDate('tanggal', '=', $get_item->tanggal)->get();

        DB::beginTransaction();
        try {
            if(!empty($get_setoran))
            {
                foreach($get_setoran as $row)
                {
                    Simpan_tabungan_m::where('id', $row->id)->update(['tutup_buku' => 0]);
                }

            }
            if(!empty($get_penarikan))
            {
                foreach($get_penarikan as $row)
                {
                    Tarik_tabungan_m::where('id', $row->id)->update(['tutup_buku' => 0]);
                }

            }
            Tutup_buku_m::where('id', $id)->delete();
            DB::commit();

            $response = [
                "message" => 'Tutup buku berhasil dibatalkan',
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
