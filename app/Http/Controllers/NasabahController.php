<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Nasabah_m;
use App\Http\Model\User_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use Helpers;
use DB;
use Response;

class NasabahController extends Controller
{
    protected $jenis_kelamin = [
        ['id' => 'Laki-Laki', 'desc' => 'Laki-Laki'],
        ['id' => 'Perempuan', 'desc' => 'Perempuan'],
    ];

    protected $status = [
        ['id' => '1', 'desc' => 'Aktif'],
        ['id' => '0', 'desc' => 'Non-Aktif'],
    ];

    public function __construct()
    {
        $this->model = New Nasabah_m;
        $this->model_user = New User_m;
        $this->nameroutes = 'nasabah';
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
                'title'             => 'Data Nasabah',
                'breadcrumb'        => 'List Data Nasabah',
                'headerModalTambah' => 'TAMBAH DATA NASABAH',
                'headerModalEdit'   => 'UBAH DATA NASABAH',
                'urlDatatables'     => 'nasabah/datatables',
                'idDatatables'      => 'dt_nasabah'
            );
            return view('nasabah.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_nasabah' => $this->model->gen_code('NS'),
            'tanggal_daftar' => date('Y-m-d')
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_jenis_kelamin'  => $this->jenis_kelamin,
            'option_status'         => $this->status,
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['id_nasabah'] = $this->model->gen_code('NS');

            $user = $request->input('u');
            $user['id_user'] = $this->model_user->gen_code('U');
            $user['nama_user'] =  $header['nama_nasabah'];
            $user['password'] =  bcrypt($user['password']);
            $user['alamat'] =  $header['alamat_nasabah'];
            $user['no_telp'] =  $header['no_telp'];
            $user['jenis_kelamin'] =  $header['jenis_kelamin'];
            $user['jabatan'] =  'Nasabah';

            if(!empty($header['anggota']) && $header['anggota'] == 1){
                $header['anggota'] = $header['anggota'];
                $header['no_anggota'] = $this->model->gen_code_anggota('AG');
                $header['no_rek_sim_pokok'] = $this->model->gen_code_no_rek_pokok('SP');
                $header['no_rek_sim_wajib'] = $this->model->gen_code_no_rek_wajib('SW');
            }

            

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
                $header['id_user'] = $id_user;
                $this->model->insert_data($header);
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
            'option_status'             => $this->status,
            'nameroutes'                => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');

            $user = $request->input('u');
            $user['nama_user'] =  $header['nama_nasabah'];
            $user['alamat'] =  $header['alamat_nasabah'];
            $user['no_telp'] =  $header['no_telp'];
            $user['jenis_kelamin'] =  $header['jenis_kelamin'];
            $user['jabatan'] =  'Nasabah';

            if(empty($header['anggota']) && $get_data->anggota == 1){
                $header['anggota'] = 0;
                $header['no_anggota'] = null;
                $header['no_rek_sim_pokok'] = null;
                $header['no_rek_sim_wajib'] = null;
            }
            
            if(!empty($header['anggota']) && $header['anggota'] == 1 && $get_data->anggota != 1){
                $header['anggota'] = $header['anggota'];
                $header['no_anggota'] = $this->model->gen_code_anggota('AG');
                $header['no_rek_sim_pokok'] = $this->model->gen_code_no_rek_pokok('SP');
                $header['no_rek_sim_wajib'] = $this->model->gen_code_no_rek_wajib('SW');
            }


           //validasi dari model
           $validator = Validator::make( $header, [
                'id_nasabah' => [Rule::unique('tb_nasabah')->ignore($get_data->id_nasabah, 'id_nasabah')],
                'no_rek_sim_pokok' => [Rule::unique('tb_nasabah')->ignore($get_data->no_rek_sim_pokok, 'no_rek_sim_pokok')],
                'no_rek_sim_wajib' => [Rule::unique('tb_nasabah')->ignore($get_data->no_rek_sim_wajib, 'no_rek_sim_wajib')],
                'no_rek_tabungan' => [Rule::unique('tb_nasabah')->ignore($get_data->no_rek_tabungan, 'no_rek_tabungan')],
             ]);
           if ($validator->fails()) {
               $response = [
                   'message' => $validator->errors()->first(),
                   'status' => 'error',
                   'code' => 500,
               ];
               return Response::json($response);
           }

            //cek password berubah/tidak
            if($user['password'] != $get_data->password)
            {
                $user['password'] = bcrypt($user['password']);
            }

                      
            //insert data
            DB::beginTransaction();
            try {
                if(empty( $get_data->id_user)){
                    $user['id_user'] = $this->model_user->gen_code('U');
                    $id_user = User_m::insertGetId($user);
                    $header['id_user'] = $id_user;
                    $this->model->update_data($header, $id);
                }else{
                    $this->model_user->update_data($user, $get_data->id_user);
                    $this->model->update_data($header, $id);
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
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function datatables_collection_no_tabungan()
    {
        $data = $this->model->get_all_no_tabungan();
        return Datatables::of($data)->make(true);
    }


}
