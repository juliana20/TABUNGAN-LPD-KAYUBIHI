<?php

namespace App\Http\Controllers;

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

    protected $jenis_kendaraan = [
        ['id' => 'Roda Dua', 'desc' => 'Roda Dua'],
        ['id' => 'Roda Tiga', 'desc' => 'Roda Tiga'],
        ['id' => 'Roda Empat', 'desc' => 'Roda Empat'],
    ];

    protected $jenis_pembayaran = [
        ['id' => 'DP', 'desc' => 'Down Payment'],
        ['id' => 'Lunas', 'desc' => 'Lunas'],
    ];

    public function __construct(Transaksi_samsat_m $model)
    {
        $this->model = $model;
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
            //request dari view
            $header = $request->input('f');
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
                $this->model->update_data($header, $id);
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


}
