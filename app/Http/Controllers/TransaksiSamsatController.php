<?php

namespace App\Http\Controllers;

use App\Http\Model\Jurnal_umum_m;
use App\Http\Model\Transaksi_samsat_log_m;
use App\Http\Model\Transaksi_samsat_m;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use DateTime;
use Helpers;
use DB;
use Illuminate\Validation\Rule;
use Response;
use PDF;

class TransaksiSamsatController extends Controller
{
    protected $model;
    protected $model_log;

    protected $jenis_kendaraan = [
        ['id' => 'Roda Dua', 'desc' => 'Roda Dua'],
        ['id' => 'Roda Tiga', 'desc' => 'Roda Tiga'],
        ['id' => 'Roda Empat', 'desc' => 'Roda Empat'],
    ];

    protected $jenis_pembayaran = [
        ['id' => 'DP', 'desc' => 'Down Payment'],
        ['id' => 'Lunas', 'desc' => 'Lunas'],
    ];

    public function __construct(Transaksi_samsat_m $model, Transaksi_samsat_log_m $model_log)
    {
        $this->model = $model;
        $this->model_log = $model_log;
        $this->nameroutes = 'transaksi-samsat-kendaraan';
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
            'title'             => 'Transaksi Samsat Kendaraan',
            'header'            => 'Data Transaksi Samsat Kendaraan',
            'urlDatatables'     => $this->nameroutes.'/datatables',
            'idDatatables'      => 'dt_transaksi_samsat',
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
        );
        return view('transaksi_samsat.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'kode_transaksi_samsat' => $this->model->gen_code('ST'),
            'tanggal_samsat' => date('Y-m-d'),
            'tanggal_lunas' => date('Y-m-d'),
            'jumlah_tagihan' => 0,
            'biaya_jasa' => 0,
            'total_bayar' => 0
        ];
        $data = array(
            'title'      => 'Transaksi Samsat Kendaraan',
            'header'     => 'Buat Transaksi Samsat Kendaraan',
            'item'       => (object) $item,
            'submit_url' => url()->current(),
            'is_edit'    => FALSE,
            'nameroutes' => $this->nameroutes,
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
            'option_jenis_pembayaran' => $this->jenis_pembayaran,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
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
                $header['kode_transaksi_samsat'] = $this->model->gen_code('ST');
                $header['tanggal_lunas'] = date('Y-m-d h:i:s', strtotime($header['tanggal_lunas']));
                $this->model->insert_data($header);
                #insert jurnal umum
                $jurnal_umum = [
                    [
                        'kode_jurnal' => $header['kode_transaksi_samsat'], 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 7, #Pendapatan Jasa Samsat Kendaraan
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => 0,
                        'kredit' => $header['total_bayar'],
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                    [
                        'kode_jurnal' => $header['kode_transaksi_samsat'], 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 1, #Kas
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => $header['total_bayar'],
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                ];
                Jurnal_umum_m::insert($jurnal_umum);
                DB::commit();
    
                $response = [
                    "message" => 'Transaksi samsat kendaraan berhasil tersimpan',
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

        return view('transaksi_samsat.form', $data);

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
            'title'         => 'Transaksi Samsat Kendaraan',
            'header'        => 'Ubah Transaksi Samsat Kendaraan',
            'item'          => $get_data,
            'is_edit'       => TRUE,
            'submit_url'    => url()->current(),
            'nameroutes'    => $this->nameroutes,
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
            'option_jenis_pembayaran' => $this->jenis_pembayaran,
        ];

        //jika form sumbit
        if($request->post())
        {
            if($get_data->ada_perubahan == 1)
            {
                $response = [
                    "success" => false,
                    'message' => 'Terdapat perubahan yg belum di validasi!',
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            
            //request dari view
            $header = $request->input('f');
            $log = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header,[
                'kode_transaksi_samsat' => ['required', Rule::unique('t_samsat')->ignore($get_data->kode_transaksi_samsat, 'kode_transaksi_samsat')]
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
                $log['user_id'] = Helpers::getId();
                $log['created_at'] = date('Y-m-d H:i:s');
                $log['updated_at'] = date('Y-m-d H:i:s');
                $id_log = $this->model_log::insertGetId($log);

                $update['ada_perubahan'] = 1;
                $update['log_id'] = $id_log;
                $this->model->update_data($update, $id);
                 #insert jurnal umum
                 $jurnal_umum = [
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_samsat, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 7, #Pendapatan Jasa Samsat Kendaraan
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => 0,
                        'kredit' => $header['total_bayar'],
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_samsat, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 1, #Kas
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => $header['total_bayar'],
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                ];
                $cek_jurnal_already = Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_samsat)->first();
                if(!empty($cek_jurnal_already)){
                    Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_samsat)->delete();
                }
                Jurnal_umum_m::insert($jurnal_umum);
                DB::commit();

                $response = [
                    "message" => 'Transaksi samsat kendaraan berhasil diperbarui',
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
        
        return view('transaksi_samsat.form', $data);
    }

    public function show(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'title'      => 'Transaksi Samsat Kendaraan',
            'header'     => 'Lihat Transaksi Samsat Kendaraan',
            'item'       => $get_data,
            'is_edit'    => TRUE,
            'submit_url' => url()->current(),
            'nameroutes' => $this->nameroutes,
        ];

        return view('transaksi_samsat.show', $data);
    }


    public function cetak_nota($id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'  => $get_data,
            'title' => 'NOTA TRANSAKSI',
        ];
        $pdf = PDF::loadView('transaksi_samsat.print.cetak_nota', $data)->setPaper('a5', 'portait');
        return $pdf->stream('Bukti Samsat Kendaraan '.$get_data->nama_pelanggan.'.pdf'); 
    }

    public function datatables_collection(Request $request)
    {
        $params = $request->all();
        $data = $this->model->get_all($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_collection_perubahan()
    {
        $data = $this->model_log->get_notif();
        return Datatables::of($data)->make(true);
    }

    public function lookupPerubahan(Request $request, $log_id)
    {
        $get_data = $this->model_log->get_one($log_id);
        $data = [
            'title'      => 'Transaksi Samsat Kendaraan',
            'header'     => 'Lihat Transaksi Samsat Kendaraan',
            'item'       => $get_data,
            'is_edit'    => TRUE,
            'submit_url' => url()->current(),
            'nameroutes' => $this->nameroutes,
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
            'option_jenis_pembayaran' => $this->jenis_pembayaran,
        ];

        return view('transaksi_samsat.lookup_perubahan', $data);
    }

    public function lookupDataSebelumnya(Request $request, $log_id)
    {
        $get_data = $this->model->get_by(['t_samsat.log_id' => $log_id]);
        $data = [
            'title'      => 'Transaksi Samsat Kendaraan Sebelumnya',
            'header'     => 'Lihat Transaksi Samsat Kendaraan Sebelumnya',
            'item'       => $get_data,
            'is_edit'    => TRUE,
            'submit_url' => url()->current(),
            'nameroutes' => $this->nameroutes,
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
            'option_jenis_pembayaran' => $this->jenis_pembayaran,
        ];

        return view('transaksi_samsat.lookup_perubahan', $data);
    }


    public function validasiPerubahan(Request $request, $log_id)
    {
        $get_data = $this->model_log->get_one($log_id);
        $data = [
            'title'      => 'Perubahan Transaksi Samsat Kendaraan',
            'header'     => 'Lihat Perubahan Transaksi Samsat Kendaraan',
            'item'       => $get_data,
            'is_edit'    => TRUE,
            'submit_url' => url()->current(),
            'nameroutes' => $this->nameroutes,
            'option_jenis_kendaraan' => $this->jenis_kendaraan,
            'option_jenis_pembayaran' => $this->jenis_pembayaran,
        ];

         //jika form sumbit
         if($request->post())
         {
            $header = $request->input('f');
            $header['ada_perubahan'] = 0;
             //insert data
             DB::beginTransaction();
             try {
                 $this->model_log->update_data(['validasi' => 1], $log_id);
                 $this->model->update_by($header, ['log_id' => $log_id]);
                 #insert jurnal umum
                 $jurnal_umum = [
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_samsat, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 7, #Pendapatan Jasa Samsat Kendaraan
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => 0,
                        'kredit' => $header['total_bayar'],
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_samsat, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 1, #Kas
                        'tanggal' => $header['tanggal_samsat'],
                        'debet' => $header['total_bayar'],
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran Samsat Kendaraan'
                    ],
                ];
                $cek_jurnal_already = Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_samsat)->first();
                if(!empty($cek_jurnal_already)){
                    Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_samsat)->delete();
                }
                Jurnal_umum_m::insert($jurnal_umum);
                DB::commit();
 
                 $response = [
                     "success" => true,
                     "message" => 'Perubahan transaksi samsat kendaraan berhasil divalidasi',
                     'status' => 'success',
                     'code' => 200,
                 ];
            
             } catch (\Exception $e) {
                 DB::rollback();
                 $response = [
                     "success" => false,
                     "message" => $e->getMessage(),
                     'status' => 'error',
                     'code' => 500,
                     
                 ];
             }
             return Response::json($response); 
         }
         

        return view('transaksi_samsat.form_perubahan', $data);
    }
    public function getNotif()
    {
        $get_data = $this->model_log->get_notif();
        $response = [
           "success" => true,
           'status' => 'success',
           'code' => 200,
           'data' => $get_data->take(5),
           'count' => $get_data->count()
        ];
        return Response::json($response);
    }

    public function semuaPerubahan()
    {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Semua Perubahan Transaksi Samsat Kendaraan',
            'header'            => 'Semua Perubahan Transaksi Samsat Kendaraan',
            'urlDatatables'     => $this->nameroutes.'/datatables_perubahan',
            'idDatatables'      => 'dt_samsat_kendaraan'
        );
        return view('transaksi_samsat.datatable_perubahan',$data);
    }


}
