<?php

namespace App\Http\Controllers;

use App\Http\Model\Bunga_tabungan_m;
use Illuminate\Http\Request;
use App\Http\Model\Nasabah_m;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\User_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;
use Helpers;
use File;
use Illuminate\Support\Str;

class NasabahController extends Controller
{
    protected $jenis_kelamin = [
        ['id' => 'Laki-Laki', 'desc' => 'Laki-Laki'],
        ['id' => 'Perempuan', 'desc' => 'Perempuan'],
    ];

    protected $model;
    protected $model_user;
    protected $model_tabungan;
    public function __construct(Nasabah_m $model, User_m $model_user, Tabungan_m $model_tabungan)
    {
        $this->model = $model;
        $this->model_user = $model_user;
        $this->model_tabungan = $model_tabungan;
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
            'title'             => 'Nasabah',
            'header'            => 'Data Nasabah',
            'breadcrumb'        => 'List Data Nasabah',
            'headerModalTambah' => 'TAMBAH DATA NASABAH',
            'headerModalEdit'   => 'UBAH DATA NASABAH',
            'urlDatatables'     => 'nasabah/datatables',
            'idDatatables'      => 'dt_nasabah',
            'is_kepala'         => (Helpers::getJabatan() == 'Kepala')
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

            if($request->file('foto_ktp')){
                $file = $request->file('foto_ktp');
                #validasi image upload
                $validate = \Validator::make($request->all(), [
                    'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:10000',
                ]);
                if ($validate->fails()) {
                    $response = [
                        'success'   => false,
                        'status'    => 'error',
                        'message'   => $validate->errors()->first(),
                    ];
                    return response()->json($response);
                }
                #upload image
                $filename = date('YmdHi').'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
                $header['foto_ktp'] = $filename;
                #hapus file sebelumnya
                if (!file_exists(public_path('ktp'))) {
                    File::makeDirectory(public_path('ktp'), $mode = 0777, true, true);
                }
                $file->move(public_path('ktp'), $filename);
            }

            

            DB::beginTransaction();
            try {
                $id_user = User_m::insertGetId($user);
                $header['user_id'] = $id_user;
                $id_nasabah = Nasabah_m::insertGetId($header);

                $m_tabungan['no_rekening'] = $this->model_tabungan->gen_no_rek_tabungan('');
                $m_tabungan['nasabah_id'] = $id_nasabah;
                $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];

                $validator = Validator::make( $m_tabungan, $this->model_tabungan->rules['insert']);
                if ($validator->fails()) {
                    $response = [
                        'message' => $validator->errors()->first(),
                        'status' => 'error',
                        'code' => 500,
                    ];
                    return Response::json($response);
                }
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
            $header = $request->input('f');
            $user = $request->input('u');
            if($request->file('foto_ktp')){
                $file = $request->file('foto_ktp');
                #validasi image upload
                $validate = \Validator::make($request->all(), [
                    'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:10000',
                ]);
                if ($validate->fails()) {
                    $response = [
                        'success'   => false,
                        'status'    => 'error',
                        'message'   => $validate->errors()->first(),
                    ];
                    return response()->json($response);
                }
                #upload image
                $filename = date('YmdHi').'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
                $header['foto_ktp'] = $filename;
                #hapus file sebelumnya
                $path = public_path('ktp/'.$get_data->foto_ktp);
                if (!file_exists(public_path('ktp'))) {
                    File::makeDirectory(public_path('ktp'), $mode = 0777, true, true);
                }
                if (file_exists($path) && !empty($get_data->foto_ktp)) {
                    unlink($path);
                }
                $file->move(public_path('ktp'), $filename);
            }
            //request dari view

            $user['nama'] = $header['nama_nasabah'];
            $user['alamat'] = $header['alamat'];
            $user['jenis_kelamin'] = $header['jenis_kelamin'];
            // if($user['password'] != $get_data->password)
            // {
            //     $user['password'] = bcrypt($user['password']);
            // }
            //validasi dari model
            $validator = Validator::make( $header, [
                // 'id_nasabah' => [Rule::unique('m_nasabah')->ignore($get_data->id_nasabah, 'id_nasabah')],
                'nama_nasabah' => 'required',
				'alamat' => 'required',
				'no_ktp' => 'required|digits_between:16,16|numeric'
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

                $cek_m_tabungan = $this->model_tabungan->get_by(['nasabah_id' => $get_data->id]);
                if(empty($cek_m_tabungan))
                {
                    $m_tabungan['no_rekening'] = $this->model_tabungan->gen_no_rek_tabungan('');
                    $m_tabungan['nasabah_id'] = $get_data->id;
                    $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];
                    $validator = Validator::make( $m_tabungan, $this->model_tabungan->rules['insert']);
                    if ($validator->fails()) {
                        $response = [
                            'message' => $validator->errors()->first(),
                            'status' => 'error',
                            'code' => 500,
                        ];
                        return Response::json($response);
                    }
                    $this->model_tabungan->insert_data($m_tabungan);
                }else{
                    //validasi dari model
                    $m_tabungan['tanggal_daftar'] = $header['tanggal_daftar'];
                    $validator = Validator::make( $header, [
                        'no_rekening' => [Rule::unique('m_tabungan')->ignore($get_data->no_rekening, 'no_rekening')],
                    ]);
                    if ($validator->fails()) {
                        $response = [
                            'message' => $validator->errors()->first(),
                            'status' => 'error',
                            'code' => 500,
                        ];
                        return Response::json($response);
                    }
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

    public function datatables_collection(Request $request)
    {
        $params = $request->all();
        $data = $this->model->get_all($params);
        return Datatables::of($data)->make(true);
    }

    public function resetPassword($id)
    {
        $get_nasabah = Nasabah_m::where('id', $id)->first();
        DB::beginTransaction();
        try {
            $this->model_user->update_data([
                'password' => bcrypt('lpdkayubihi12345')
            ], $get_nasabah->user_id);
            DB::commit();

            $response = [
                "message" => 'Password nasabah berhasil di reset',
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

    public function generateBunga()
    {
        $get_setoran = Simpan_tabungan_m::select(
            'tabungan_id',
            'tanggal',
            DB::raw('MONTH(tanggal) periode_bunga_bulan'),
            DB::raw('YEAR(tanggal) periode_bunga_tahun'),
            DB::raw('MAX(tanggal) as tanggal'),
            DB::raw('MAX(saldo_akhir) as saldo_akhir')
        )
        ->groupby('tabungan_id','tanggal','periode_bunga_bulan','periode_bunga_tahun')
        ->get();
        
        DB::beginTransaction();
        try {
            foreach($get_setoran as $row)
            {
                $collection = [
                    'tabungan_id' => $row->tabungan_id,
                    'tanggal' => $row->tanggal,
                    'periode_bunga_bulan' => $row->periode_bunga_bulan,
                    'periode_bunga_tahun' => $row->periode_bunga_tahun,
                    'saldo_akhir' => $row->saldo_akhir,
                    'nominal_bunga' => (0.5 *  $row->saldo_akhir) / 100,
                ];

                $check_exist = Bunga_tabungan_m::where([
                    'tabungan_id' => $row->tabungan_id,
                    'tanggal' => $row->tanggal,
                    'periode_bunga_bulan' => $row->periode_bunga_bulan,
                    'periode_bunga_tahun' => $row->periode_bunga_tahun
                ])->first();
                if(!empty($check_exist))
                {
                    Bunga_tabungan_m::where('id', $check_exist->id)->update([
                        'tanggal' => $row->tanggal,
                        'saldo_akhir' => $row->saldo_akhir,
                        'nominal_bunga' => (0.5 *  $row->saldo_akhir) / 100
                    ]);
                }else{
                    Bunga_tabungan_m::insert($collection);
                }
            }

            DB::commit();

            $response = [
                'success' => true,
                'message' => 'Generate bunga tabungan berhasil',
                'status' => 'success',
                'code' => 200,
            ];
        
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'status' => 'error',
                'code' => 500,
                
            ];
        }
        return Response::json($response); 
    }


}
