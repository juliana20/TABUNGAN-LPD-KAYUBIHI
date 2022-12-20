<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;
use Helpers;
use Illuminate\Support\Facades\Redirect;

class TransaksiKolektorController extends Controller
{
    protected $model_simpanan;
    protected $model_penarikan;
    protected $model_tabungan;
    public function __construct(Simpan_tabungan_m $model_simpanan, Tarik_tabungan_m $model_penarikan,Tabungan_m $model_tabungan)
    {
        $this->model_simpanan = $model_simpanan;
        $this->model_penarikan = $model_penarikan;
        $this->model_tabungan = $model_tabungan;
        $this->nameroutes = 'transaksi-kolektor';
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
        );
        return view('transaksi_kolektor.transaksi',$data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transaksi(Request $request)
    {
        $no_rekening = $request->input('no_rekening');
        $get_tabungan = $this->model_tabungan->get_by(['m_tabungan.no_rekening' => $no_rekening]);
        if(empty($get_tabungan)){
            alert()->warning('No rekening nasabah tidak di temukan!', 'Perhatian!')->persistent('Tutup');
            return redirect()->back();
        }

        $get_tabungan->tanggal = date('Y-m-d');
        $data = [
            'item'                      => $get_tabungan,
            'params'                    => $no_rekening,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
        ];
        
        return view('transaksi_kolektor.form', $data);
    }

    public function prosesTransaksi(Request $request, $no_rekening)
    {
        //request dari view
        $get_tabungan = $this->model_tabungan->get_by(['m_tabungan.no_rekening' => $no_rekening]);
        $header = $request->input('f');
        if($header['nominal_penarikan'] == 0 && $header['nominal_setoran'] == 0){
            $response = [
                'message' => 'Silahkan masukkan nominal transaksi, setoran / penarikan!',
                'status' => 'error',
                'code' => 500,
            ];
            return Response::json($response);
        }

        if(!empty($header['nominal_setoran']) && $header['nominal_setoran'] < 10000){
            $response = [
                'message' => 'Nominal setoran minimal Rp10.000',
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
        if((!empty($header['nominal_penarikan']) && $header['nominal_penarikan'] > 0) && (!empty($header['nominal_setoran']) && $header['nominal_setoran'] > 0)){
            $response = [
                'message' => 'Tidak dapat melakukan transaksi setoran dan penarikan secara bersamaan!',
                'status' => 'error',
                'code' => 500,
            ];
            return Response::json($response);
        }  
        //insert data
        DB::beginTransaction();
        try {
            if($header['nominal_setoran'] > 0)
            {
                $saldo_akhir = $get_tabungan->saldo_awal + $header['nominal_setoran'];
                $data_setoran = [
                    'tanggal' => $header['tanggal'],
                    'user_id' => Helpers::getId(),
                    'tabungan_id' => $get_tabungan->id,
                    'nominal_setoran' => $header['nominal_setoran'],
                    'saldo_awal' => $get_tabungan->saldo_awal,
                    'saldo_akhir' => $saldo_akhir
                ];
                $this->model_simpanan->insert($data_setoran);
                $this->model_tabungan->update_data(['saldo' => $saldo_akhir], $get_tabungan->id);
            }

            if($header['nominal_penarikan'] > 0)
            {
                $saldo_akhir = $get_tabungan->saldo_awal - $header['nominal_penarikan'];
                if($saldo_akhir < 0)
                {
                    $response = [
                        'message' => 'Jumlah saldo tidak mencukupi!',
                        'status' => 'error',
                        'code' => 500,
                    ];
                    return Response::json($response);
                }

                $data_penarikan = [
                    'tanggal' => $header['tanggal'],
                    'user_id' => Helpers::getId(),
                    'tabungan_id' => $get_tabungan->id,
                    'nominal_penarikan' => $header['nominal_penarikan'],
                    'saldo_awal' => $get_tabungan->saldo_awal,
                    'saldo_akhir' => $saldo_akhir
                ];
                $this->model_penarikan->insert($data_penarikan);
                $this->model_tabungan->update_data(['saldo' => $saldo_akhir], $get_tabungan->id);
            }

            DB::commit();

            $response = [
                "message" => 'Data transaksi tabungan berhasil tersimpan',
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



}
