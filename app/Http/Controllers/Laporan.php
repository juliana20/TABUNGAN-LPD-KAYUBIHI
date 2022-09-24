<?php

namespace App\Http\Controllers;

use App\Http\Model\Akun_m;
use App\Http\Model\Transaksi_online_m;
use App\Http\Model\Transaksi_sampah_m;
use App\Http\Model\Transaksi_samsat_m;
use App\Http\Model\Jurnal_umum_m;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\User_m;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Psr7\Response;
use PDF;
use Helpers;

class Laporan extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function transaksiTabunganHarian()
   {
        $item = [
            'date' => Carbon::now()->toDateString(),
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Laporan Transaksi Tabungan Harian',
            'url_print'         => 'laporan/transaksi-tabungan-harian/print',
            'kolektor'   => User_m::where('jabatan', 'Kolektor')->get()
        );

        return view('laporan.form.transaksi_tabungan_harian', $data);
    }

    public function printTransaksiTabunganHarian(Request $request)
    {
        $params = $request->input('f');
        $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->where('t_simpan_tabungan.tanggal', $params['date'])
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_simpan_tabungan.nominal_setoran',
                        'm_user.nama as kolektor'
                    );

        if(!empty($params['kolektor'])){
            $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
        }

        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->where('t_tarik_tabungan.tanggal', $params['date'])
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        'm_user.nama as kolektor'
                    );

        if(!empty($params['kolektor'])){
            $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
        }

        $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');

        $data = [
            'params'            => (object) $params,
            'item'              => $result,
            'title'             => 'Laporan Transaksi Tabungan Harian',
        ];
        $pdf = PDF::loadView('laporan.print.cetak_transaksi_tabungan_harian', $data, $params)->setPaper('a4', 'landscape');
        return $pdf->stream($params['date'].'laporan_transaksi_tabungan_harian.pdf'); 
    }

    public function transaksiTabunganBulanan()
    {
        $item = [
            'date_start' => Carbon::now()->startOfMonth()->toDateString(),
            'date_end'   => Carbon::now()->endOfMonth()->toDateString()
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Laporan Transaksi Tabungan Bulanan',
            'url_print'         => 'laporan/transaksi-tabungan-bulanan/print',
            'kolektor'   => User_m::where('jabatan', 'Kolektor')->get()
        );

        return view('laporan.form.transaksi_tabungan_bulanan', $data);
     }
 
     public function printTransaksiTabunganBulanan(Request $request)
     {
         $params = $request->input('f');
         $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->whereBetween('t_simpan_tabungan.tanggal',[$params['date_start'], $params['date_end']])
                     ->select(
                        't_simpan_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_simpan_tabungan.nominal_setoran',
                         'm_user.nama as kolektor'
                     );

        if(!empty($params['kolektor'])){
            $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
        }
 
        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->whereBetween('t_tarik_tabungan.tanggal',[$params['date_start'], $params['date_end']])
                    ->select(
                        't_tarik_tabungan.tanggal',
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        'm_user.nama as kolektor'
                    );

        if(!empty($params['kolektor'])){
            $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
        }
             
 
         $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Transaksi Tabungan Bulanan',
         ];
         $pdf = PDF::loadView('laporan.print.cetak_transaksi_tabungan_bulanan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_transaksi_tabungan_bulanan.pdf'); 
     }

     
    public function simpananTabungan()
    {
        $item = [
            'date_start' => Carbon::now()->startOfMonth()->toDateString(),
            'date_end'   => Carbon::now()->endOfMonth()->toDateString()
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Laporan Simpanan Tabungan',
            'url_print'         => 'laporan/simpanan-tabungan/print',
            'kolektor'   => User_m::where('jabatan', 'Kolektor')->get()
        );

        return view('laporan.form.simpanan_tabungan', $data);
     }

     public function printSimpananTabungan(Request $request)
     {
         $params = $request->input('f');
         $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->whereBetween('t_simpan_tabungan.tanggal',[$params['date_start'], $params['date_end']])
                     ->select(
                        't_simpan_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_simpan_tabungan.nominal_setoran',
                         'm_user.nama as kolektor'
                     );

        if(!empty($params['kolektor'])){
            $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
        }  
 
         $result = collect($simpanan->get()->toArray())->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Simpanan Tabungan',
         ];
         $pdf = PDF::loadView('laporan.print.cetak_simpanan_tabungan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_simpanan_tabungan.pdf'); 
     }

     public function penarikanTabungan()
    {
        $item = [
            'date_start' => Carbon::now()->startOfMonth()->toDateString(),
            'date_end'   => Carbon::now()->endOfMonth()->toDateString()
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Laporan Penarikan Tabungan',
            'url_print'         => 'laporan/penarikan-tabungan/print',
            'kolektor'   => User_m::where('jabatan', 'Kolektor')->get()
        );

        return view('laporan.form.penarikan_tabungan', $data);
     }

     public function printPenarikanTabungan(Request $request)
     {
         $params = $request->input('f');
         $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->whereBetween('t_tarik_tabungan.tanggal',[$params['date_start'], $params['date_end']])
                     ->select(
                        't_tarik_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_tarik_tabungan.nominal_penarikan',
                         'm_user.nama as kolektor'
                     );

        if(!empty($params['kolektor'])){
            $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
        }  
 
         $result = collect($penarikan->get()->toArray())->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Penarikan Tabungan',
         ];
         $pdf = PDF::loadView('laporan.print.cetak_penarikan_tabungan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_penarikan_tabungan.pdf'); 
     }

  
}