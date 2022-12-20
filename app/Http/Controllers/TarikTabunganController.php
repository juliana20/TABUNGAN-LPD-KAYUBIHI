<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;
use Helpers;

class TarikTabunganController extends Controller
{
    protected $model;
    protected $model_tabungan;
    public function __construct(Tarik_tabungan_m $model, Tabungan_m $model_tabungan)
    {
        $this->model = $model;
        $this->model_tabungan = $model_tabungan;
        $this->nameroutes = 'tarik-tabungan';
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
            'title'             => 'Tarik Tabungan',
            'header'            => 'Data Tarik Tabungan',
            'breadcrumb'        => 'List Data Tarik Tabungan',
            'headerModalEdit'   => 'TARIK TABUNGAN',
            'urlDatatables'     => 'tarik-tabungan/datatables',
            'idDatatables'      => 'dt_tarik_tabungan'
        );
        return view('tarik_tabungan.datatable', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $get_data = $this->model_tabungan->get_one($id);
        $get_data->tanggal = empty($get_data->tanggal) ? date('Y-m-d') : $get_data->tanggal;
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
            $header['user_id'] = Helpers::getId(); 
            $header['tabungan_id'] = $id;
            //validasi dari model
            $validator = Validator::make( $header, $this->model->rules['insert']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

            if(!empty($header['nominal_penarikan']) && $header['nominal_penarikan'] < 10000){
                $response = [
                    'message' => 'Nominal penarikan minimal Rp10.000',
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
                      
            //insert data
            DB::beginTransaction();
            try {
                $this->model->insert($header);
                $this->model_tabungan->update_data(['saldo' => $header['saldo_akhir']], $id);
                DB::commit();

                $response = [
                    "message" => 'Data penarikan tabungan berhasil tersimpan',
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
        
        return view('tarik_tabungan.form', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model_tabungan->get_all();
        return Datatables::of($data)->make(true);
    }


}
