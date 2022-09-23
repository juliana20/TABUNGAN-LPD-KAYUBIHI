<?php

namespace App\Http\Controllers;

use App\Http\Model\Pegawai_m;
use Illuminate\Http\Request;
use App\Http\Model\User_m;
use Validator;
use DataTables;
use DB;
use Response;

class PegawaiController extends Controller
{
    protected $jabatan = [
        ['id' => 'Tata', 'desc' => 'Tata Usaha'],
        ['id' => 'Kepala', 'desc' => 'Kepala'],
        ['id' => 'Kolektor', 'desc' => 'Kolektor'],
        ['id' => 'Nasabah', 'desc' => 'Nasabah']
    ];

    protected $jenis_kelamin = [
        ['id' => 'Laki-Laki', 'desc' => 'Laki-Laki'],
        ['id' => 'Perempuan', 'desc' => 'Perempuan'],
    ];

    protected $model;
    protected $model_user;
    public function __construct(Pegawai_m $model, User_m $model_user)
    {
        $this->model = $model;
        $this->model_user = $model_user;
        $this->nameroutes = 'pegawai';
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
            'title'             => 'Pegawai',
            'header'            => 'Data Pegawai',
            'breadcrumb'        => 'List Data Pegawai',
            'headerModalTambah' => 'TAMBAH DATA PEGAWAI',
            'headerModalEdit'   => 'UBAH DATA PEGAWAI',
            'urlDatatables'     => 'pegawai/datatables',
            'idDatatables'      => 'dt_pegawai'
        );
        return view('pegawai.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_pegawai' => $this->model->gen_code('PG'),
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_jabatan'         => $this->jabatan,
            'nameroutes'            => $this->nameroutes,
            'option_jenis_kelamin'  => $this->jenis_kelamin,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');

            $user = $request->input('u');
            $user['id_user'] = $this->model_user->gen_code('U');
            $user['password'] = bcrypt($user['password']);
            $user['nama'] = $header['nama_pegawai'];
            $user['alamat'] = $header['alamat'];
            $user['jenis_kelamin'] = $header['jenis_kelamin'];

            DB::beginTransaction();
            try {
                $id_user = User_m::insertGetId($user);
                $header['user_id'] = $id_user;
                
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
                $this->model->insert_data($header);
                DB::commit();
    
                $response = [
                    'success' => true,
                    "message" => 'Data pegawai berhasil dibuat',
                    'status' => 'success',
                    'code' => 200,
                ];
    
            } catch (\Exception $e) {
                DB::rollback();
                $response = [
                    'success' => false,
                    "message" => $e->getMessage(),
                    'status' => 'error',
                    'code' => 500,
                    
                ];
            }
    
            return Response::json($response);
        }

        return view('pegawai.form', $data);

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
            'option_jabatan'            => $this->jabatan,
            'nameroutes'                => $this->nameroutes,
            'option_jenis_kelamin'  => $this->jenis_kelamin,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
            $user = $request->input('u');

           //validasi dari model
           $validator = Validator::make( $header, $this->model->rules['update']);
           if ($validator->fails()) {
               $response = [
                    'success' => false,
                   'message' => $validator->errors()->first(),
                   'status' => 'error',
                   'code' => 500,
               ];
               return Response::json($response);
           }

           $tb_user = [
                'username' => $user['username'],
                'nama' => $header['nama_pegawai'],
                'alamat' => $header['alamat'],
                'jenis_kelamin' => $header['jenis_kelamin'],
                'jabatan' => $user['jabatan']
            ];

            //cek password berubah/tidak
            if($user['password'] != $get_data->password){
                $tb_user['password'] =  bcrypt($user['password']);
            }

            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data($header, $id);
                $this->model_user->update_data($tb_user, $get_data->user_id);
                DB::commit();

                $response = [
                    'success' => true,
                    "message" => 'Data pegawai berhasil diperbarui',
                    'status' => 'success',
                    'code' => 200,
                ];
           
            } catch (\Exception $e) {
                DB::rollback();
                $response = [
                    'success' => false,
                    "message" => $e->getMessage(),
                    'status' => 'error',
                    'code' => 500,
                    
                ];
            }
            return Response::json($response); 
        }
        
        return view('pegawai.form', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }


}
