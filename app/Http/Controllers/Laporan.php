<?php

namespace App\Http\Controllers;

use App\Http\Model\Akun_m;
use App\Http\Model\Transaksi_online_m;
use App\Http\Model\Transaksi_sampah_m;
use App\Http\Model\Transaksi_samsat_m;
use App\Http\Model\Jurnal_umum_m;
use App\Http\Model\Nasabah_m;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\User_m;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Psr7\Response;
use PDF;
use Helpers;
use DataTables;

class Laporan extends Controller
{
    protected $bulan = [
        ['id' => '1', 'desc' => 'Januari'],
        ['id' => '2', 'desc' => 'Februari'],
        ['id' => '3', 'desc' => 'Maret'],
        ['id' => '4', 'desc' => 'April'],
        ['id' => '5', 'desc' => 'Mei'],
        ['id' => '6', 'desc' => 'Juni'],
        ['id' => '7', 'desc' => 'Juli'],
        ['id' => '8', 'desc' => 'Agustus'],
        ['id' => '9', 'desc' => 'September'],
        ['id' => '10', 'desc' => 'Oktober'],
        ['id' => '11', 'desc' => 'November'],
        ['id' => '12', 'desc' => 'Desember'],
    ];

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
            'kolektor'          => User_m::whereIn('jabatan', ['Kolektor', 'Admin'])->get(),
            'title'             => 'Laporan Harian',
            'header'            => 'Laporan Harian Tabungan LPD Desa Adat Kayubihi',
            'urlDatatables'     => 'laporan/transaksi-tabungan-harian/datatables',
            'idDatatables'      => 'dt_laporan_harian'
        );

        return view('laporan.form.laporan_transaksi_tabungan_harian', $data);
    }

    public function transaksiTabunganHarianDatatables(Request $request)
    {
        $params = $request->input();
        $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_simpan_tabungan.nominal_setoran',
                        't_simpan_tabungan.tanggal',
                        'm_user.nama as kolektor'
                    )
                    ->addSelect(\DB::raw("'0' as nominal_penarikan"));

        if(!empty($params['kolektor'])){
            $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
        }
        if(!empty($params['tanggal'])){
            $simpanan->where('t_simpan_tabungan.tanggal', $params['tanggal']);
        }

        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        't_tarik_tabungan.tanggal',
                        'm_user.nama as kolektor'
                    )
                    ->addSelect(\DB::raw("'0' as nominal_setoran"));

        if(!empty($params['kolektor'])){
            $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
        }
        if(!empty($params['tanggal'])){
            $penarikan->where('t_tarik_tabungan.tanggal', $params['tanggal']);
        }

        $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');
        return Datatables::of($result )->make(true);
    }

    public function printTransaksiTabunganHarian(Request $request)
    {
        $params = $request->input();
        $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_simpan_tabungan.nominal_setoran',
                        't_simpan_tabungan.tanggal',
                        'm_user.nama as kolektor'
                    )
                    ->addSelect(\DB::raw("'0' as nominal_penarikan"));

        if(!empty($params['kolektor'])){
            $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
        }
        if(!empty($params['tanggal'])){
            $simpanan->where('t_simpan_tabungan.tanggal', $params['tanggal']);
        }


        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select(
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        't_tarik_tabungan.tanggal',
                        'm_user.nama as kolektor'
                    )
                    ->addSelect(\DB::raw("'0' as nominal_setoran"));

        if(!empty($params['kolektor'])){
            $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
        }
        if(!empty($params['tanggal'])){
            $penarikan->where('t_tarik_tabungan.tanggal', $params['tanggal']);
        }

        $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');

        $data = [
            'params'            => (object) $params,
            'item'              => $result,
            'title'             => 'Laporan Transaksi Tabungan Harian',
            'kolektor'          => User_m::where('id', $params['kolektor'])->first()
        ];

        $pdf = PDF::loadView('laporan.print.cetak_transaksi_tabungan_harian', $data, $params)->setPaper('a4', 'landscape');
        return $pdf->stream($params['tanggal'].'laporan_transaksi_tabungan_harian.pdf'); 
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
            'kolektor'          => User_m::whereIn('jabatan', ['Kolektor', 'Admin'])->get(),
            'title'             => 'Laporan Bulanan',
            'header'            => 'Laporan Bulanan Tabungan LPD Desa Adat Kayubihi',
            'urlDatatables'     => 'laporan/transaksi-tabungan-bulanan/datatables',
            'idDatatables'      => 'dt_laporan_bulanan',
            'bulan'             => $this->bulan
        );

        return view('laporan.form.laporan_transaksi_tabungan_bulanan', $data);
     }
 
     public function transaksiTabunganBulananDatatables(Request $request)
     {
         $params = $request->input();
         $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->select(
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_simpan_tabungan.nominal_setoran',
                         't_simpan_tabungan.tanggal',
                         'm_user.nama as kolektor'
                     )
                     ->addSelect(\DB::raw("'0' as nominal_penarikan"));
 
         if(!empty($params['kolektor'])){
             $simpanan->where('t_simpan_tabungan.user_id', $params['kolektor']);
         }
         if(!empty($params['bulan'])){
            $simpanan->where(DB::raw('MONTH(t_simpan_tabungan.tanggal)'), $params['bulan']);
         }
         if(!empty($params['tahun'])){
            $simpanan->where(DB::raw('YEAR(t_simpan_tabungan.tanggal)'), $params['tahun']);
        }
 
         $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->select(
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_tarik_tabungan.nominal_penarikan',
                         't_tarik_tabungan.tanggal',
                         'm_user.nama as kolektor'
                     )
                     ->addSelect(\DB::raw("'0' as nominal_setoran"));
 
         if(!empty($params['kolektor'])){
             $penarikan->where('t_tarik_tabungan.user_id', $params['kolektor']);
         }
         if(!empty($params['bulan'])){
             $penarikan->where(DB::raw('MONTH(t_tarik_tabungan.tanggal)'), $params['bulan']);
         }
         if(!empty($params['tahun'])){
            $penarikan->where(DB::raw('YEAR(t_tarik_tabungan.tanggal)'), $params['tahun']);
        }
 
         $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');
         return Datatables::of($result )->make(true);
     }

     
     public function printTransaksiTabunganBulanan(Request $request)
     {
        $params = $request->input();
        $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    //  ->whereBetween('t_simpan_tabungan.tanggal',[$params['date_start'], $params['date_end']])
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
        if(!empty($params['bulan'])){
            $simpanan->where(DB::raw('MONTH(t_simpan_tabungan.tanggal)'), $params['bulan']);
        }
        if(!empty($params['tahun'])){
            $simpanan->where(DB::raw('YEAR(t_simpan_tabungan.tanggal)'), $params['tahun']);
        }
        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    // ->whereBetween('t_tarik_tabungan.tanggal',[$params['date_start'], $params['date_end']])
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
        if(!empty($params['bulan'])){
            $penarikan->where(DB::raw('MONTH(t_tarik_tabungan.tanggal)'), $params['bulan']);
        }
        if(!empty($params['tahun'])){
            $penarikan->where(DB::raw('YEAR(t_tarik_tabungan.tanggal)'), $params['tahun']);
        }
             
 
         $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Transaksi Tabungan Bulanan',
             'kolektor'          => User_m::where('id', $params['kolektor'])->first()
         ];
         $pdf = PDF::loadView('laporan.print.cetak_transaksi_tabungan_bulanan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['bulan'].$params['tahun'].'laporan_transaksi_tabungan_bulanan.pdf'); 
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
            'nasabah'          => Nasabah_m::get(),
            'title'             => 'Laporan Simpanan Tabungan',
            'header'            => 'Laporan Simpanan Tabungan LPD Desa Adat Kayubihi',
            'urlDatatables'     => 'laporan/simpanan-tabungan/datatables',
            'idDatatables'      => 'dt_laporan_simpanan'
        );

        return view('laporan.form.laporan_simpanan_tabungan', $data);
     }

     public function simpananTabunganDatatables(Request $request)
     {
         $params = $request->input();
         $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
         ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
         ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
         ->select(
            't_simpan_tabungan.tanggal',
             'm_nasabah.id_nasabah',
             'm_nasabah.nama_nasabah',
             'm_tabungan.no_rekening',
             't_simpan_tabungan.nominal_setoran',
             'm_user.nama as kolektor'
         );

        if(!empty($params['nasabah'])){
            $get_tabungan = Tabungan_m::where('nasabah_id', $params['nasabah'])->first();
            $simpanan->where('t_simpan_tabungan.tabungan_id', $get_tabungan->id);
        }  
        if(!empty($params['batas_awal']) && !empty($params['batas_akhir'])){
            $simpanan->whereBetween('t_simpan_tabungan.tanggal',[$params['batas_awal'], $params['batas_akhir']]);
        }  
        
         return Datatables::of($simpanan->get())->make(true);
     }


     public function printSimpananTabungan(Request $request)
     {
         $params = $request->input();
         $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->select(
                        't_simpan_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_simpan_tabungan.nominal_setoran',
                         'm_user.nama as kolektor'
                     );

        if(!empty($params['nasabah'])){
            $get_tabungan = Tabungan_m::where('nasabah_id', $params['nasabah'])->first();
            $simpanan->where('t_simpan_tabungan.tabungan_id', $get_tabungan->id);
        }  
        if(!empty($params['batas_awal']) && !empty($params['batas_akhir'])){
            $simpanan->whereBetween('t_simpan_tabungan.tanggal',[$params['batas_awal'], $params['batas_akhir']]);
        }  
         $result = collect($simpanan->get()->toArray())->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Simpanan Tabungan LPD Desa Adat Kayubihi',
         ];
         $pdf = PDF::loadView('laporan.print.cetak_simpanan_tabungan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['batas_awal'].$params['batas_akhir'].'laporan_simpanan_tabungan.pdf'); 
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
            'nasabah'           => Nasabah_m::get(),
            'title'             => 'Laporan Penarikan Tabungan',
            'header'            => 'Laporan Penarikan Tabungan LPD Desa Adat Kayubihi',
            'urlDatatables'     => 'laporan/penarikan-tabungan/datatables',
            'idDatatables'      => 'dt_laporan_penarikan'
        );

        return view('laporan.form.laporan_penarikan_tabungan', $data);
     }

     public function penarikanTabunganDatatables(Request $request)
     {
        $params = $request->input();
        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select(
                       't_tarik_tabungan.tanggal',
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        'm_user.nama as kolektor'
                    );

       if(!empty($params['nasabah'])){
            $get_tabungan = Tabungan_m::where('nasabah_id', $params['nasabah'])->first();
            $penarikan->where('t_tarik_tabungan.tabungan_id', $get_tabungan->id);
       }  
       if(!empty($params['batas_awal']) && !empty($params['batas_akhir'])){
           $penarikan->whereBetween('t_tarik_tabungan.tanggal',[$params['batas_awal'], $params['batas_akhir']]);
       }  
        
         return Datatables::of($penarikan->get())->make(true);
     }

     public function printPenarikanTabungan(Request $request)
     {
         $params = $request->input();
         $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->select(
                        't_tarik_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_tarik_tabungan.nominal_penarikan',
                         'm_user.nama as kolektor'
                     );

        if(!empty($params['nasabah'])){
            $get_tabungan = Tabungan_m::where('nasabah_id', $params['nasabah'])->first();
            $penarikan->where('t_tarik_tabungan.tabungan_id', $get_tabungan->id);
        }  
        if(!empty($params['batas_awal']) && !empty($params['batas_akhir'])){
            $penarikan->whereBetween('t_tarik_tabungan.tanggal',[$params['batas_awal'], $params['batas_akhir']]);
        }  
 
         $result = collect($penarikan->get()->toArray())->sortby('tanggal');
         $data = [
             'params'            => (object) $params,
             'item'              => $result,
             'title'             => 'Laporan Penarikan Tabungan LPD Desa Adat Kayubihi',
         ];
         $pdf = PDF::loadView('laporan.print.cetak_penarikan_tabungan', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['batas_awal'].$params['batas_akhir'].'laporan_penarikan_tabungan.pdf'); 
     }

  
}