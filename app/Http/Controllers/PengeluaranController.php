<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Akun_m;
use App\Http\Model\Pengeluaran_detail_m;
use App\Http\Model\Pengeluaran_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use Helpers;
use DB;
use Response;
use PDF;

class PengeluaranController extends Controller
{
    protected $model;
    protected $model_detail;
    protected $model_akun;
    public function __construct(Pengeluaran_m $model, Pengeluaran_detail_m $model_detail, Akun_m $model_akun)
    {
        $this->model = $model;
        $this->model_detail = $model_detail;
        $this->model_akun = $model_akun;
        $this->nameroutes = 'pengeluaran';
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
            'title'             => 'Pengeluaran',
            'header'            => 'Data Pengeluaran',
            'urlDatatables'     => $this->nameroutes.'/datatables',
            'idDatatables'      => 'dt_pengeluaran',
        );
        return view('pengeluaran.datatable', $data);
    }

    public function create(Request $request)
    {
        $item = [
            'kode_pengeluaran' => $this->model->gen_code('PL'),
            'tanggal' => date('Y-m-d')
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Buat Pengeluaran',
            'header'            => 'Form Pengeluaran',
            'breadcrumb'        => 'Daftar Pengeluaran',
            'submit_url'        => url()->current(),
            'is_edit'           => FALSE,
            'nameroutes'        => $this->nameroutes,
            'option_akun'       => $this->model_akun->get_all()
        );

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = array_merge($item, $request->input('f'));
            $header['user_id'] = Helpers::getId();
            $header['kode_pengeluaran'] = $this->model->gen_code('PL');
            $header['tanggal'] = date('Y-m-d h:i:s', strtotime($header['tanggal']));
            $details = $request->input('details');

            $validator = Validator::make( $header, $this->model->rules['insert']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

            DB::beginTransaction();
            try {
                //insert header get id
                $id_pengeluaran = Pengeluaran_m::insertGetId($header);

                $data_details = [];
                foreach($details as $row)
                {
                    $row['pengeluaran_id'] = $id_pengeluaran;
                    $data_details[] = $row;
                }
                // insert detail
                $this->model_detail->insert_data($data_details);
                DB::commit();
    
                $response = [
                    "message" => 'Data pengeluaran berhasil tersimpan',
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

        return view('pengeluaran.form', $data);

    }

          /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $item = $this->model->get_one($id);
        $data = [
            'title'         => 'Ubah Pengeluaran',
            'header'        => 'Form Ubah Pengeluaran',
            'item'          => $item,
            'is_edit'       => TRUE,
            'breadcrumb'        => 'Daftar Pengeluaran',
            'submit_url'    => url()->current(),
            'nameroutes'    => $this->nameroutes,
            'option_akun'       => $this->model_akun->get_all(),
            'collection' => $this->model_detail->collection($id)
        ];

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['user_id'] = Helpers::getId();
            $header['tanggal'] = date('Y-m-d h:i:s', strtotime($header['tanggal']));
            $details = $request->input('details');
            //validasi dari model
            $validator = Validator::make( $header, $this->model->rules['update']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data($header, $id);
                Pengeluaran_detail_m::where('pengeluaran_id', $id)->delete();
                $data_details = [];
                foreach($details as $row)
                {
                    $row['pengeluaran_id'] = $id;
                    $data_details[] = $row;
                }
                // insert detail
                $this->model_detail->insert_data($data_details);
                DB::commit();

                $response = [
                    "message" => 'Data pengeluaran berhasil diperbarui',
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
        
        return view('pengeluaran.form', $data);
    }

    public function show(Request $request, $id)
    {
        $item = $this->model->get_one($id);
        $data = [
            'title'         => 'Lihat Pengeluaran',
            'header'        => 'Lihat Data Pengeluaran',
            'item'          => $item,
            'is_edit'       => TRUE,
            'breadcrumb'        => 'Daftar Pengeluaran',
            'submit_url'    => url()->current(),
            'nameroutes'    => $this->nameroutes,
            'option_akun'       => $this->model_akun->get_all(),
            'collection' => $this->model_detail->collection($id)
        ];

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['user_id'] = Helpers::getId();
            $header['tanggal'] = date('Y-m-d h:i:s', strtotime($header['tanggal']));
            $details = $request->input('details');
            //validasi dari model
            $validator = Validator::make( $header, $this->model->rules['update']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data($header, $id);
                Pengeluaran_detail_m::where('pengeluaran_id', $id)->delete();
                $data_details = [];
                foreach($details as $row)
                {
                    $row['pengeluaran_id'] = $id;
                    $data_details[] = $row;
                }
                // insert detail
                $this->model_detail->insert_data($data_details);
                DB::commit();

                $response = [
                    "message" => 'Data pengeluaran berhasil diperbarui',
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
        
        return view('pengeluaran.show', $data);
    }

    public function lookup_detail()
    {
        return view('pengeluaran.lookup.lookup_detail');
    }

    public function cetak_nota($id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'  => $get_data,
            'title' => 'NOTA TRANSAKSI',
            'collection' => $this->model_detail->collection($id)
        ];
        $pdf = PDF::loadView('pengeluaran.print.cetak_nota', $data)->setPaper('a4', 'portait');
        return $pdf->stream('Bukti Pengeluaran'.'.pdf'); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

}
