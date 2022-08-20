<?php

namespace App\Http\Controllers;

use App\Http\Model\Jenis_transaksi_m;
use App\Http\Model\Jurnal_umum_m;
use App\Http\Model\Transaksi_online_m;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use DateTime;
use Helpers;
use DB;
use Illuminate\Validation\Rule;
use Response;
use PDF;

class TransaksiOnlineController extends Controller
{
    protected $model;
    protected $model_jenis_transaksi;
    public function __construct(Transaksi_online_m $model, Jenis_transaksi_m $model_jenis_transaksi)
    {
        $this->model = $model;
        $this->model_jenis_transaksi = $model_jenis_transaksi;
        $this->nameroutes = 'transaksi-pembayaran-online';
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
            'title'             => 'Transaksi Pembayaran Online',
            'header'            => 'Data Transaksi Pembayaran Online',
            'urlDatatables'     => $this->nameroutes.'/datatables',
            'idDatatables'      => 'dt_transaksi_online'
        );
        return view('transaksi_online.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'kode_transaksi_online' => $this->model->gen_code('TO'),
            'tanggal' => date('Y-m-d'),
            'jumlah' => 0,
            'biaya_jasa' => 0
        ];
        $data = array(
            'title'      => 'Transaksi Pembayaran Online',
            'header'     => 'Buat Transaksi Pembayaran Online',
            'item'       => (object) $item,
            'submit_url' => url()->current(),
            'is_edit'    => FALSE,
            'nameroutes' => $this->nameroutes,
            'option_jenis_transaksi' => $this->model_jenis_transaksi->get_all(),
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
                $header['kode_transaksi_online'] = $this->model->gen_code('TO');
                $header['tanggal'] = date('Y-m-d h:i:s', strtotime($header['tanggal']));
                $this->model->insert_data($header);
                #insert jurnal umum
                $get_jenis_transaksi = Jenis_transaksi_m::where('id', $header['jenis_transaksi_id'])->first();
                $jurnal_umum = [
                    [
                        'kode_jurnal' => $header['kode_transaksi_online'], 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 6, #Pendapatan Jasa Pembayaran Online
                        'tanggal' => $header['tanggal'],
                        'debet' => 0,
                        'kredit' => $header['total_bayar'],
                        'keterangan' => 'Pembayaran '. $get_jenis_transaksi->nama
                    ],
                    [
                        'kode_jurnal' => $header['kode_transaksi_online'], 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 1, #Kas
                        'tanggal' => $header['tanggal'],
                        'debet' => $header['total_bayar'],
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran '. $get_jenis_transaksi->nama
                    ],
                ];
                Jurnal_umum_m::insert($jurnal_umum);
                DB::commit();
    
                $response = [
                    "message" => 'Transaksi pembayaran online berhasil dibuat',
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

        return view('transaksi_online.form', $data);

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
            'title'         => 'Transaksi Pembayaran Online',
            'header'        => 'Ubah Transaksi Pembayaran Online',
            'item'          => $get_data,
            'is_edit'       => TRUE,
            'submit_url'    => url()->current(),
            'nameroutes'    => $this->nameroutes,
            'option_jenis_transaksi' => $this->model_jenis_transaksi->get_all(),
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header,[
                'kode_transaksi_online' => ['required', Rule::unique('t_online')->ignore($get_data->kode_transaksi_online, 'kode_transaksi_online')]
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
                $this->model->update_data($header, $id);
                #insert jurnal umum
                $get_jenis_transaksi = Jenis_transaksi_m::where('id', $header['jenis_transaksi_id'])->first();
                $jurnal_umum = [
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_online, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 6, #Pendapatan Jasa Pembayaran Online
                        'tanggal' => $header['tanggal'],
                        'debet' => 0,
                        'kredit' => $header['total_bayar'],
                        'keterangan' => 'Pembayaran '. $get_jenis_transaksi->nama
                    ],
                    [
                        'kode_jurnal' => $get_data->kode_transaksi_online, 
                        'user_id' => Helpers::getId(),
                        'akun_id' => 1, #Kas
                        'tanggal' => $header['tanggal'],
                        'debet' => $header['total_bayar'],
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran '. $get_jenis_transaksi->nama
                    ],
                ];
                $cek_jurnal_already = Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_online)->first();
                if(!empty($cek_jurnal_already)){
                    Jurnal_umum_m::where('kode_jurnal', $get_data->kode_transaksi_online)->delete();
                }
                Jurnal_umum_m::insert($jurnal_umum);
                DB::commit();

                $response = [
                    "message" => 'Transaksi pembayaran online berhasil diperbarui',
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
        
        return view('transaksi_online.form', $data);
    }

    public function show(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'title'      => 'Transaksi Pembayaran Online',
            'header'     => 'Lihat Transaksi Pembayaran Online',
            'item'       => $get_data,
            'is_edit'    => TRUE,
            'submit_url' => url()->current(),
            'nameroutes' => $this->nameroutes,
        ];

        return view('transaksi_online.show', $data);
    }


    public function cetak_nota($id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'  => $get_data,
            'title' => 'NOTA TRANSAKSI',
        ];
        $pdf = PDF::loadView('transaksi_online.print.cetak_nota', $data)->setPaper('a5', 'portait');
        return $pdf->stream('Bukti Pembayaran Online'.'.pdf'); 
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }


}
