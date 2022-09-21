<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Nasabah_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\User_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class SimpanTabunganController extends Controller
{
    protected $model;
    protected $model_user;
    protected $model_tabungan;
    public function __construct(Nasabah_m $model, User_m $model_user, Tabungan_m $model_tabungan)
    {
        $this->model = $model;
        $this->model_user = $model_user;
        $this->model_tabungan = $model_tabungan;
        $this->nameroutes = 'simpan-tabungan';
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
            'title'             => 'Simpan Tabungan',
            'header'            => 'Data Simpan tabungan',
            'breadcrumb'        => 'List Data Simpan Tabungan',
            'headerModalTambah' => 'TAMBAH DATA SIMPAN TABUNGAN',
            'headerModalEdit'   => 'UBAH DATA SIMPAN TABUNGAN',
            'urlDatatables'     => 'simpan-tabungan/datatables',
            'idDatatables'      => 'dt_simpan_tabungan'
        );
        return view('simpan_tabungan.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'tanggal' => date('Y-m-d')
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['id_nasabah'] = $this->model->gen_code('NS');
            $user = $request->input('u');
            $user['id_user'] = $this->model_user->gen_code('U');
            $user['nama'] = $header['nama_nasabah'];
            $user['alamat'] = $header['alamat'];
            $user['jenis_kelamin'] = $header['jenis_kelamin'];
            $user['password'] = bcrypt($user['password']);
            $user['jabatan'] = 'Nasabah';

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
                $id_user = User_m::insertGetId($user);
                $header['user_id'] = $id_user;
                $id_nasabah = Nasabah_m::insertGetId($header);

                $m_tabungan['no_rekening'] = $this->model_tabungan->gen_no_rek_tabungan('');
                $m_tabungan['nasabah_id'] = $id_nasabah;
                $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];
                $this->model_tabungan->insert_data($m_tabungan);
                DB::commit();
    
                $response = [
                    "message" => 'Data nasabah berhasil dibuat',
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

        return view('nasabah.form', $data);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'option_jenis_kelamin'      => $this->jenis_kelamin,
            'nameroutes'                => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
            $user = $request->input('u');
            $user['nama'] = $header['nama_nasabah'];
            $user['alamat'] = $header['alamat'];
            $user['jenis_kelamin'] = $header['jenis_kelamin'];
            if($user['password'] != $get_data->password)
            {
                $user['password'] = bcrypt($user['password']);
            }
            //validasi dari model
            $validator = Validator::make( $header, [
                'kode' => [Rule::unique('m_pelanggan')->ignore($get_data->kode, 'kode')],
            ]);
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
                $this->model_user->update_data($user, $get_data->user_id);
                $this->model->update_data($header, $id);

                $cek_m_tabungan = $this->model_tabungan->get_by(['nasabah_id' => $get_data->nasabah_id]);
                if(empty($cek_m_tabungan))
                {
                    $m_tabungan['no_rekening'] = $this->model_tabungan->gen_no_rek_tabungan('');
                    $m_tabungan['nasabah_id'] = $get_data->id;
                    $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];
                    $this->model_tabungan->insert_data($m_tabungan);
                }else{
                    $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];
                    $this->model_tabungan->update_data($m_tabungan, $cek_m_tabungan->id);
                }
                
                DB::commit();

                $response = [
                    "message" => 'Data nasabah berhasil diperbarui',
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
        
        return view('nasabah.form', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model_tabungan->get_all();
        return Datatables::of($data)->make(true);
    }


}
