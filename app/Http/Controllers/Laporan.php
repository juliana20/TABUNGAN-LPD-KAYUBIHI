<?php

namespace App\Http\Controllers;

use App\Http\Model\Transaksi_online_m;
use App\Http\Model\Transaksi_sampah_m;
use App\Http\Model\Transaksi_samsat_m;
use App\Http\Model\Jurnal_umum_m;
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
   public function retribusiSampah()
   {
            $item = [
                'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                'date_end'   => Carbon::now()->endOfMonth()->toDateString()
            ];

            $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Retribusi Sampah',
                'url_print'         => 'laporan/retribusi-sampah/print'
            );

            return view('laporan.form.retribusi_sampah', $data);
    }

    public function printRetribusiSampah(Request $request)
    {
        $params = $request->input('f');
        $collection = Transaksi_sampah_m::join('m_pelanggan','m_pelanggan.id','=','t_sampah.pelanggan_id')
                                        ->whereBetween('t_sampah.tanggal',[$params['date_start'], $params['date_end']])
                                        ->select('t_sampah.*','m_pelanggan.nama as nama_pelanggan')
                                        ->get();

        $data = [
            'params'            => (object) $params,
            'item'              => $collection,
            'title'             => 'Laporan Retribusi Sampah',
        ];
        $pdf = PDF::loadView('laporan.print.cetak_retribusi_sampah', $data, $params)->setPaper('a4', 'landscape');
        return $pdf->stream($params['date_start'].$params['date_end'].'laporan_retribusi_sampah.pdf'); 
    }

    public function pembayaranOnline()
    {
             $item = [
                 'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                 'date_end'   => Carbon::now()->endOfMonth()->toDateString()
             ];
 
             $data = array(
                 'item'              => (object) $item,
                 'title'             => 'Laporan Pembayaran Online',
                 'url_print'         => 'laporan/pembayaran-online/print'
             );
 
             return view('laporan.form.pembayaran_online', $data);
 
     }
 
     public function printPembayaranOnline(Request $request)
     {
         $params = $request->input('f');
         $collection = Transaksi_online_m::join('m_pelanggan','m_pelanggan.id','=','t_online.pelanggan_id')
                                        ->join('m_jenis_transaksi','m_jenis_transaksi.id','=','t_online.jenis_transaksi_id')
                                        ->whereBetween('t_online.tanggal',[$params['date_start'], $params['date_end']])
                                        ->select('t_online.*','m_pelanggan.nama as nama_pelanggan','m_jenis_transaksi.nama as jenis_transaksi')
                                        ->get();
         $data = [
             'params'   => (object) $params,
             'item'     =>  $collection,
             'title'    => 'Laporan Pembayaran Online',
         ];

         $pdf = PDF::loadView('laporan.print.cetak_pembayaran_online', $data, $params)->setPaper('a4', 'landscape');
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_pembayaran_online.pdf'); 
     }

     public function samsatKendaraan()
     {
              $item = [
                  'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                  'date_end'   => Carbon::now()->endOfMonth()->toDateString()
              ];
  
              $data = array(
                  'item'              => (object) $item,
                  'title'             => 'Laporan Samsat Kendaraan',
                  'url_print'         => 'laporan/samsat-kendaraan/print'
              );
  
              return view('laporan.form.samsat_kendaraan', $data);
  
      }

      public function printSamsatKendaraan(Request $request)
      {
          $params = $request->input('f');
          $collection = Transaksi_samsat_m::join('m_pelanggan','m_pelanggan.id','=','t_samsat.pelanggan_id')
                                            ->whereBetween('t_samsat.tanggal_samsat',[$params['date_start'], $params['date_end']])
                                            ->select('t_samsat.*','m_pelanggan.nama as nama_pelanggan')
                                            ->get();
          $data = [
              'params'   => (object) $params,
              'item'     =>  $collection,
              'title'    => 'Laporan Samsat Kendaraan',
          ];
 
          
          $pdf = PDF::loadView('laporan.print.cetak_samsat_kendaraan', $data, $params)->setPaper('a4', 'landscape');
          return $pdf->stream($params['date_start'].$params['date_end'].'laporan_samsat_kendaraan.pdf'); 
      }

      public function jurnalUmum()
      {
               $item = [
                   'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                   'date_end'   => Carbon::now()->endOfMonth()->toDateString()
               ];
   
               $data = array(
                   'item'              => (object) $item,
                   'title'             => 'Laporan Jurnal Umum',
                   'url_print'         => 'laporan/jurnal-umum/print'
               );
   
               return view('laporan.form.jurnal_umum', $data);
   
       }
 
       public function printJurnalUmum(Request $request)
       {
           $params = $request->input('f');
           $query = Jurnal_umum_m::join('m_user','t_jurnal_umum.user_id','=','m_user.id')
                    ->join('m_akun','t_jurnal_umum.akun_id','=','m_akun.id')
                    ->select(
                        't_jurnal_umum.*',
                        'm_user.nama as nama_user',
                        'm_akun.kode_akun',
                        'm_akun.nama_akun'
                    )
                    ->whereBetween('t_jurnal_umum.tanggal',[$params['date_start'], $params['date_end']])
                    ->orderBy('t_jurnal_umum.tanggal','asc')
                    ->orderBy('t_jurnal_umum.id','asc')
                    ->orderBy('t_jurnal_umum.debet','desc')
                    ->get();

            $evidence_number = $evidence_number_before = NULL;
            $collection = array();
            foreach( $query as $row ){
            $evidence_number = $row->kode_jurnal;
            $row->tanggal = ( $evidence_number_before == $evidence_number ) ? '' : date('d-m-Y', strtotime($row->tanggal));
            $row->kode_jurnal =	( $evidence_number_before == $evidence_number ) ? '' : $evidence_number;
            $row->debet = $row->debet;
            $row->kredit = $row->kredit;
            $row->kode_jurnal_hide = $evidence_number;
            $collection[] = $row;

            $evidence_number_before = $evidence_number;
            }

           $data = [
               'params'   => (object) $params,
               'item'     =>  $collection,
               'title'    => 'Laporan Jurnal Umum',
           ];
  
           $pdf = PDF::loadView('laporan.print.cetak_jurnal_umum', $data, $params)->setPaper('a4', 'landscape');
           return $pdf->stream($params['date_start'].$params['date_end'].'laporan_jurnal_umum.pdf'); 
       }
  
        private function get_buku_besar($id_akun, $date_start, $date_end)
        {
            //JIKA AKUN TABUNGAN SUKARELA
            if($id_akun == '20103') {
                $collection6 = DB::table('tb_tabungan_sukarela as a')
                                    ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                    ->whereBetween('a.tanggal',[$date_start, $date_end])
                                    ->select(
                                        'a.tanggal',
                                        'a.id_tabungan_sukarela as no_bukti',
                                        'a.kredit',
                                        'a.debet',
                                        'b.nama_nasabah as keterangan'
                                    )
                                    ->get();
            }
            //JIKA AKUN TABUNGAN BERJANGKA
            elseif($id_akun == '20104') {
                $collection6 = DB::table('tb_tabungan_berjangka as a')
                                    ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                                    ->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
                                    ->whereBetween('b.tanggal',[$date_start, $date_end])
                                    ->select(
                                        'b.tanggal',
                                        'a.id_tabungan_berjangka as no_bukti',
                                        'b.kredit',
                                        'b.debet',
                                        'c.nama_nasabah as keterangan'
                                    )
                                    ->get();
            }
            //JIKA AKUN Simpanan Wajib
            elseif($id_akun == '20105') {
                $collection6 = DB::table('tb_simpanan_wajib as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->whereBetween('a.tanggal',[$date_start, $date_end])
                                ->select(
                                    'a.tanggal',
                                    'a.id_simpanan_wajib as no_bukti',
                                    'a.kredit',
                                    'a.debet',
                                    'b.nama_nasabah as keterangan'
                                )
                                ->get();
            //JIKA AKUN Simpanan Pokok
            }elseif($id_akun == '20106') {
                $collection6 = DB::table('tb_simpanan_pokok as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->whereBetween('a.tanggal',[$date_start, $date_end])
                                ->select(
                                    'a.tanggal',
                                    'a.id_simpanan_pokok as no_bukti',
                                    'a.kredit',
                                    'a.debet',
                                    'b.nama_nasabah as keterangan'
                                )
                                ->get();           
            }else{
                $jurnal = DB::table('tb_jurnal as a')
                        ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('b.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_jurnal as no_bukti',
                            'b.keterangan',
                            'b.kredit',
                            'b.debet'
                        )
                        ->get();
                $mutasi = DB::table('tb_mutasi_kas as a')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('a.akun_id', $id_akun)
                        ->where('a.status_batal', 0)
                        ->select(
                            'a.tanggal',
                            'a.id_mutasi_kas as no_bukti',
                            'a.keterangan',
                            'a.debet',
                            'a.kredit'
                        )
                        ->get();
                $mutasi_detail = DB::table('tb_mutasi_kas as a')
                        ->join('tb_mutasi_kas_detail as b','a.id_mutasi_kas','=','b.id_mutasi_kas')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('b.akun_id', $id_akun)
                        ->where('a.akun_id', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_mutasi_kas as no_bukti',
                            'b.keterangan',
                            'b.kredit',
                            'b.nominal as debet'
                        )
                        ->get();

                $simpanan_pokok = DB::table('tb_simpanan_pokok as a')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_simpanan_pokok as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Simpanan Pokok' as keterangan"))
                        ->get();

                $simpanan_wajib = DB::table('tb_simpanan_wajib as a')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_simpanan_wajib as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Simpanan Wajib' as keterangan"))
                        ->get();

                $tabungan_berjangka = DB::table('tb_tabungan_berjangka as a')
                        ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                        ->whereBetween('b.tanggal',[$date_start, $date_end])
                        ->where('b.id_akun', $id_akun)
                        ->select(
                            'b.tanggal',
                            'a.id_tabungan_berjangka as no_bukti',
                            'b.kredit as debet',
                            'b.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Tabungan Berjangka' as keterangan"))
                        ->get();

                $tabungan_sukarela = DB::table('tb_tabungan_sukarela as a')
                        ->whereBetween('a.tanggal',[$date_start, $date_end])
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_tabungan_sukarela as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Tabungan Sukarela' as keterangan"))
                        ->get();

                $collection1 = $jurnal->merge($mutasi)->sortBy('tanggal');
                $collection2 = $collection1->merge($mutasi_detail)->sortBy('tanggal');
                $collection3 = $collection2->merge($simpanan_pokok)->sortBy('tanggal');
                $collection4 = $collection3->merge($simpanan_wajib)->sortBy('tanggal');
                $collection5 = $collection4->merge($tabungan_berjangka)->sortBy('tanggal');
                $collection6 = $collection5->merge($tabungan_sukarela)->sortBy('tanggal');
            }

            return $collection6;
        }

        
        private function get_buku_besar_saldo_awal($id_akun, $date)
        {
            //JIKA AKUN TABUNGAN SUKARELA
            if($id_akun == '20103') {
                $collection6 = DB::table('tb_tabungan_sukarela as a')
                                    ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                    ->where('a.tanggal','<=', $date)
                                    ->select(
                                        'a.tanggal',
                                        'a.id_tabungan_sukarela as no_bukti',
                                        'a.kredit',
                                        'a.debet',
                                        'b.nama_nasabah as keterangan'
                                    )
                                    ->get();
            }
            //JIKA AKUN TABUNGAN BERJANGKA
            elseif($id_akun == '20104') {
                $collection6 = DB::table('tb_tabungan_berjangka as a')
                                    ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                                    ->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
                                    ->where('b.tanggal','<=', $date)
                                    ->select(
                                        'b.tanggal',
                                        'a.id_tabungan_berjangka as no_bukti',
                                        'b.kredit',
                                        'b.debet',
                                        'c.nama_nasabah as keterangan'
                                    )
                                    ->get();
            }
            //JIKA AKUN Simpanan Wajib
            elseif($id_akun == '20105') {
                $collection6 = DB::table('tb_simpanan_wajib as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->where('a.tanggal','<=', $date)
                                ->select(
                                    'a.tanggal',
                                    'a.id_simpanan_wajib as no_bukti',
                                    'a.kredit',
                                    'a.debet',
                                    'b.nama_nasabah as keterangan'
                                )
                                ->get();
            //JIKA AKUN Simpanan Pokok
            }elseif($id_akun == '20106') {
                $collection6 = DB::table('tb_simpanan_pokok as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->where('a.tanggal','<=', $date)
                                ->select(
                                    'a.tanggal',
                                    'a.id_simpanan_pokok as no_bukti',
                                    'a.kredit',
                                    'a.debet',
                                    'b.nama_nasabah as keterangan'
                                )
                                ->get();           
            }else{
                $jurnal = DB::table('tb_jurnal as a')
                        ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                        ->where('a.tanggal','<=', $date)
                        ->where('b.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_jurnal as no_bukti',
                            'b.keterangan',
                            'b.kredit',
                            'b.debet'
                        )
                        ->get();
                $mutasi = DB::table('tb_mutasi_kas as a')
                        ->where('a.tanggal','<=', $date)
                        ->where('a.akun_id', $id_akun)
                        ->where('a.status_batal', 0)
                        ->select(
                            'a.tanggal',
                            'a.id_mutasi_kas as no_bukti',
                            'a.keterangan',
                            'a.debet',
                            'a.kredit'
                        )
                        ->get();
                $mutasi_detail = DB::table('tb_mutasi_kas as a')
                        ->join('tb_mutasi_kas_detail as b','a.id_mutasi_kas','=','b.id_mutasi_kas')
                        ->where('a.tanggal','<=', $date)
                        ->where('b.akun_id', $id_akun)
                        ->where('a.akun_id', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_mutasi_kas as no_bukti',
                            'b.keterangan',
                            'b.kredit',
                            'b.nominal as debet'
                        )
                        ->get();

                $simpanan_pokok = DB::table('tb_simpanan_pokok as a')
                        ->where('a.tanggal','<=', $date)
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_simpanan_pokok as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Simpanan Pokok' as keterangan"))
                        ->get();

                $simpanan_wajib = DB::table('tb_simpanan_wajib as a')
                        ->where('a.tanggal','<=', $date)
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_simpanan_wajib as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Simpanan Wajib' as keterangan"))
                        ->get();

                $tabungan_berjangka = DB::table('tb_tabungan_berjangka as a')
                        ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                        ->where('b.tanggal','<=', $date)
                        ->where('b.id_akun', $id_akun)
                        ->select(
                            'b.tanggal',
                            'a.id_tabungan_berjangka as no_bukti',
                            'b.kredit as debet',
                            'b.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Tabungan Berjangka' as keterangan"))
                        ->get();

                $tabungan_sukarela = DB::table('tb_tabungan_sukarela as a')
                        ->where('a.tanggal','<=', $date)
                        ->where('a.id_akun', $id_akun)
                        ->select(
                            'a.tanggal',
                            'a.id_tabungan_sukarela as no_bukti',
                            'a.kredit as debet',
                            'a.debet as kredit'
                        )
                        ->addSelect(DB::raw("'Tabungan Sukarela' as keterangan"))
                        ->get();

                $collection1 = $jurnal->merge($mutasi)->sortBy('tanggal');
                $collection2 = $collection1->merge($mutasi_detail)->sortBy('tanggal');
                $collection3 = $collection2->merge($simpanan_pokok)->sortBy('tanggal');
                $collection4 = $collection3->merge($simpanan_wajib)->sortBy('tanggal');
                $collection5 = $collection4->merge($tabungan_berjangka)->sortBy('tanggal');
                $collection6 = $collection5->merge($tabungan_sukarela)->sortBy('tanggal');
            }

            return $collection6;
        }
      public function print_buku_besar(Request $request)
      {

        $params = $request->input('f');
        $get_akun = DB::table('tb_akun')->where('id_akun', $params['id_akun'])->first();
        //GET SALDO AWAL
        $saldo_awal = DB::table('tb_akun')
                        ->select('saldo_awal')
                        ->where('id_akun',  $params['id_akun'])
                        ->first();
        //GET SALDO AKHIR BULAN LALU
        $dateBeforeFirst = $params['date_start'].'first day of last month';
        $dtFirst = date_create($dateBeforeFirst);
        $dateBeforeLast = $params['date_start'].'last day of last month';
        $dtLast = date_create($dateBeforeLast);

        $collection_saldo_sebelumnya = self::get_buku_besar_saldo_awal($params['id_akun'], $dtLast->format('Y-m-d'));
        $debet = 0; $kredit = 0;$saldo_akhir_bulan_lalu = 0;
        if(!empty($collection_saldo_sebelumnya)) :
            foreach($collection_saldo_sebelumnya as $row):
                $debet += $row->debet; 
                $kredit += $row->kredit; 
                //jika akun tabungan sukarela
                if($params['id_akun'] == '20103' || $params['id_akun'] == '20104' || $params['id_akun'] == '20105' || $params['id_akun'] == '20106')
                {
                    $saldo_akhir_bulan_lalu = ( $row->debet > 0) ? $saldo_akhir_bulan_lalu - $row->debet : $saldo_akhir_bulan_lalu + $row->kredit;
                }else{
                    $saldo_akhir_bulan_lalu = ( $row->debet > 0) ? $saldo_akhir_bulan_lalu + $row->debet : $saldo_akhir_bulan_lalu - $row->kredit;
                }

            endforeach;
        endif;
         

        $data = [
            'params'       => (object) $params,
            'item'         => self::get_buku_besar($params['id_akun'], $params['date_start'], $params['date_end']),
            'title'        => 'Laporan Buku Besar',
            'akun'         => $get_akun,
            'saldo_akhir_bulan_lalu' => $saldo_akhir_bulan_lalu,
            'saldo_awal'   => $saldo_awal->saldo_awal
        ];

        $pdf = PDF::loadView('laporan.print.cetak_buku_besar', $data, $params)->setPaper('a4', 'landscape');
        return $pdf->stream($params['date_start'].$params['date_end'].'laporan_buku_besar.pdf'); 
      }

       public function print_laba_rugi(Request $request)
       {
            $params = $request->input('f');
            $bunga_pinjaman = DB::table('tb_pinjaman as a')
                                ->join('tb_pinjaman_detail as b','a.id_pinjaman','=','b.id_pinjaman')
                                ->whereBetween('b.tanggal',[$params['date_start'], $params['date_end']])
                                ->select(DB::raw('SUM(b.bunga) AS total'))
                                ->first();
            $biaya_admin = DB::table('tb_pinjaman as a')
                                ->whereBetween('a.tgl_realisasi',[$params['date_start'], $params['date_end']])
                                ->select(DB::raw('SUM(a.biaya_admin) AS total'))
                                ->first();

            $anggota_berhenti = DB::table('tb_nasabah as a')
                                ->select('a.*')
                                ->where('a.berhenti_anggota', 1)
                                ->get();

            $pendapatan_koperasi = DB::table('tb_akun as a')
                                ->join('tb_mutasi_kas_detail as b','b.akun_id','=','a.id_akun')
                                ->join('tb_mutasi_kas as c','c.id_mutasi_kas','=','b.id_mutasi_kas')
                                ->where('a.id_akun','40101')
                                ->whereBetween('c.tanggal',[$params['date_start'], $params['date_end']])
                                ->where('c.status_batal', 0)
                                ->select(
                                    DB::raw('SUM(b.kredit) AS total'))
                                ->first();
            $pendapatan_bunga_tabungan = DB::table('tb_akun as a')
                                ->join('tb_mutasi_kas_detail as b','b.akun_id','=','a.id_akun')
                                ->join('tb_mutasi_kas as c','c.id_mutasi_kas','=','b.id_mutasi_kas')
                                ->where('a.id_akun','40103')
                                ->where('c.status_batal', 0)
                                ->whereBetween('c.tanggal',[$params['date_start'], $params['date_end']])
                                ->select(
                                    DB::raw('SUM(b.kredit) AS total'))
                                ->first();
            $pendapatan_denda = DB::table('tb_pinjaman_detail as a')
                                ->whereBetween('a.tanggal',[$params['date_start'], $params['date_end']])
                                ->select(DB::raw('SUM(a.denda) AS total'))
                                ->first();
            $pendapatan_denda2 = DB::table('tb_tabungan_berjangka as a')
                                // ->whereBetween('a.tanggal_awal',[$params['date_start'], $params['date_end']])
                                ->select(DB::raw('SUM(a.denda_pinalti) AS total'))
                                ->first();

            $pendapatan = DB::table('tb_akun as a')
                        ->join('tb_mutasi_kas_detail as b','b.akun_id','=','a.id_akun')
                        ->join('tb_mutasi_kas as c','c.id_mutasi_kas','=','b.id_mutasi_kas')
                        ->where('a.golongan','Pendapatan')
                        ->where('c.status_batal', 0)
                        ->whereBetween('c.tanggal',[$params['date_start'], $params['date_end']])
                        ->select(
                            'a.nama_akun',
                            'a.golongan',
                            'a.kelompok',
                            'a.id_akun',
                            DB::raw('SUM(b.nominal) AS debet'),
                            DB::raw('SUM(b.kredit) AS kredit'))
                        ->groupBy(
                            'a.nama_akun',
                            'a.golongan',
                            'a.kelompok',
                            'a.id_akun')
                        ->get();
            foreach($pendapatan as $row):
                $collection_pendapatan[$row->kelompok][] = $row;
            endforeach;

            $biaya = DB::table('tb_akun as a')
                    ->join('tb_mutasi_kas_detail as b','b.akun_id','=','a.id_akun')
                    ->join('tb_mutasi_kas as c','c.id_mutasi_kas','=','b.id_mutasi_kas')
                    ->where('a.golongan','Biaya')
                    ->whereBetween('c.tanggal',[$params['date_start'], $params['date_end']])
                    ->where('c.status_batal', 0)
                    ->select(
                        'a.nama_akun',
                        'a.golongan',
                        'a.kelompok',
                        'a.id_akun',
                        DB::raw('SUM(b.nominal) AS debet'),
                        DB::raw('SUM(b.kredit) AS kredit'))
                    ->groupBy(
                        'a.nama_akun',
                        'a.golongan',
                        'a.kelompok',
                        'a.id_akun')
                    ->get();
            foreach($biaya as $row):
                $collection_biaya[$row->kelompok][] = $row;
            endforeach;

           $data = [
               'params'        => (object) $params,
               'pendapatan'    => (!empty($collection_pendapatan)) ? (object) $collection_pendapatan : [],
               'biaya'         => (!empty($collection_biaya)) ? (object) $collection_biaya : [],
               'title'         => 'Laporan Laba Rugi',
               'bunga_pinjaman' => $bunga_pinjaman,
               'biaya_admin'   => $biaya_admin,
               'biaya_admin2' => ( count($anggota_berhenti) * 50000),
               'pendapatan_koperasi' => $pendapatan_koperasi,
               'pendapatan_bunga_tabungan' => $pendapatan_bunga_tabungan,
               'pendapatan_denda' => $pendapatan_denda,
               'pendapatan_denda2' => $pendapatan_denda2
           ]; 
 

           $pdf = PDF::loadView('laporan.print.cetak_laba_rugi', $data, $params)->setPaper('a4', 'portait');
           return $pdf->stream($params['date_start'].$params['date_end'].'laporan_laba_rugi.pdf'); 
       }

       private function get_summary($id_akun, $date_start, $date_end)
       {
            $jurnal = DB::table('tb_jurnal as a')
                    ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                    ->leftjoin('tb_akun as c','c.id_akun','=','b.id_akun')
                    ->whereBetween('a.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(b.debet) AS debet'),
                        DB::raw('SUM(b.kredit) AS kredit'),
                    ])
                    ->where([
                        'b.id_akun' => $id_akun,
                        'a.status_batal' => 0
                    ])->first();

            $mutasi_kas = DB::table('tb_mutasi_kas as a')
                    ->leftjoin('tb_akun as b','b.id_akun','=','a.akun_id')
                    ->whereBetween('a.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(a.debet) AS debet'),
                        DB::raw('SUM(a.kredit) AS kredit'),
                    ])
                    ->where([
                        'a.akun_id' => $id_akun,
                        'a.status_batal' => 0
                    ])->first();

            $mutasi_kas_detail = DB::table('tb_mutasi_kas_detail as a')
                    ->leftjoin('tb_akun as b','b.id_akun','=','a.akun_id')
                    ->join('tb_mutasi_kas as c','a.id_mutasi_kas','=','c.id_mutasi_kas')
                    ->whereBetween('c.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(a.nominal) AS debet'),
                        DB::raw('SUM(a.kredit) AS kredit'),
                    ])
                    ->where([
                        'a.akun_id' => $id_akun,
                        'c.status_batal' => 0
                    ])->first();

            $simpanan_pokok = DB::table('tb_simpanan_pokok as a')
                    ->leftjoin('tb_akun as b','b.id_akun','=','a.id_akun')
                    ->whereBetween('a.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(a.debet) AS debet'),
                        DB::raw('SUM(a.kredit) AS kredit'),
                    ])
                    ->where([
                        'a.id_akun' => $id_akun
                    ])->first();
            
            $simpanan_wajib = DB::table('tb_simpanan_wajib as a')
                    ->leftjoin('tb_akun as b','b.id_akun','=','a.id_akun')
                    ->whereBetween('a.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(a.debet) AS debet'),
                        DB::raw('SUM(a.kredit) AS kredit'),
                    ])
                    ->where([
                        'a.id_akun' => $id_akun
                    ])->first();

            $tabungan_berjangka = DB::table('tb_tabungan_berjangka as a')
                    ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                    ->leftjoin('tb_akun as c','c.id_akun','=','b.id_akun')
                    ->whereBetween('b.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(b.debet) AS debet'),
                        DB::raw('SUM(b.kredit) AS kredit'),
                    ])
                    ->where([
                        'b.id_akun' => $id_akun
                    ])->first();
            $tabungan_sukarela = DB::table('tb_tabungan_sukarela as a')
                    ->leftjoin('tb_akun as b','b.id_akun','=','a.id_akun')
                    ->whereBetween('a.tanggal', [$date_start, $date_end])
                    ->select([
                        DB::raw('SUM(a.debet) AS debet'),
                        DB::raw('SUM(a.kredit) AS kredit'),
                    ])
                    ->where([
                        'a.id_akun' => $id_akun
                    ])->first();

        
        return ($tabungan_sukarela->debet - $tabungan_sukarela->kredit) + ($tabungan_berjangka->debet - $tabungan_berjangka->kredit)  + ($jurnal->debet - $jurnal->kredit) + ($mutasi_kas->debet - $mutasi_kas->kredit) + ($mutasi_kas_detail->debet - $mutasi_kas_detail->kredit)  + ($simpanan_pokok->debet - $simpanan_pokok->kredit ) + ($simpanan_wajib->debet - $simpanan_wajib->kredit);
       }
   
       public function print_neraca(Request $request)
       {
            $params = $request->input('f');
            $aktiva = DB::table('tb_akun as a')
                        ->select('a.id_akun','a.nama_akun','a.kelompok', 'a.saldo_awal','a.normal_pos')
                        ->where([
                            'golongan' => 'Aktiva'
                        ])->get();

            $passiva = DB::table('tb_akun as a')
                        ->select('a.id_akun','a.nama_akun','a.kelompok','a.saldo_awal','a.normal_pos')
                        ->whereIn('golongan', ['Hutang','Modal'])
                        ->whereNotIn('id_akun', ['20101','20105','20106','20103','20104'])
                        ->get();

            $collection_aktiva = [];
            foreach($aktiva as $akt):
                $get_saldo = self::get_buku_besar($akt->id_akun, $params['date_start'], $params['date_end']);
                $debet = 0; $kredit = 0;$saldo_akhir = 0;
                    foreach($get_saldo as $row):
                        $debet += $row->debet; 
                        $kredit += $row->kredit; 
                        $saldo_akhir = ( $row->debet > 0) ? $saldo_akhir + $row->debet : $saldo_akhir - $row->kredit;
                    endforeach;

                //GET SALDO AKHIR BULAN LALU
                $dateBeforeFirst = $params['date_start'].'first day of last month';
                $dtFirst = date_create($dateBeforeFirst);
                $dateBeforeLast = $params['date_start'].'last day of last month';
                $dtLast = date_create($dateBeforeLast);

                $collection_saldo_sebelumnya = self::get_buku_besar_saldo_awal($akt->id_akun, $dtLast->format('Y-m-d'));
                $debet = 0; $kredit = 0;$saldo_akhir_bulan_lalu = 0;
                if(!empty($collection_saldo_sebelumnya)) :
                    foreach($collection_saldo_sebelumnya as $row):
                        $debet += $row->debet; 
                        $kredit += $row->kredit; 
                        $saldo_akhir_bulan_lalu = ( $row->debet > 0 ) ? $saldo_akhir_bulan_lalu + $row->debet : $saldo_akhir_bulan_lalu - $row->kredit;
                    endforeach;
                endif;


                $collection_aktiva = [
                    'id_akun' => $akt->id_akun,
                    'nama_akun' => $akt->nama_akun,
                    'normal_pos' => $akt->normal_pos,
                    'nilai' => ( $saldo_akhir > 0) ? $saldo_akhir + $saldo_akhir_bulan_lalu + $akt->saldo_awal : $saldo_akhir + $akt->saldo_awal,
                ];

                $data_collect_aktiva[$akt->kelompok][] = $collection_aktiva;

            endforeach;

            $collection_passiva = [];
            foreach($passiva as $pass):
                $collection_passiva = [
                    'id_akun' => $pass->id_akun,
                    'nama_akun' => $pass->nama_akun,
                    'nilai' => self::get_summary($pass->id_akun, $params['date_start'],$params['date_end']),
                ];

                $data_collect_passiva[$pass->kelompok][] = $collection_passiva;

            endforeach;
            //GET SALDO AKHIR BULAN LALU
            $dateBeforeFirst = $params['date_start'].'first day of last month';
            $dtFirst = date_create($dateBeforeFirst);
            $dateBeforeLast = $params['date_start'].'last day of last month';
            $dtLast = date_create($dateBeforeLast);

            $hutang_nasabah = DB::table('tb_pinjaman')
                                ->select(DB::raw('SUM(sisa_pinjaman) AS hutang'))
                                ->first();

            $simpanan_pokok = DB::table('tb_simpanan_pokok')
                                ->select(DB::raw('SUM(kredit) AS simpanan_pokok'))
                                ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                                ->first();

            $simpanan_pokok_bulan_lalu = DB::table('tb_simpanan_pokok')
                                ->select(DB::raw('SUM(kredit) AS simpanan_pokok'))
                                ->where('tanggal','<=', $dtLast->format('Y-m-d'))
                                ->first();
            $simpanan_wajib = DB::table('tb_simpanan_wajib')
                                ->select(DB::raw('SUM(kredit) AS simpanan_wajib'))
                                ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                                ->first();
            $simpanan_wajib_bulan_lalu = DB::table('tb_simpanan_wajib')
                                ->select(DB::raw('SUM(kredit) AS simpanan_wajib'))
                                ->where('tanggal','<=', $dtLast->format('Y-m-d'))
                                ->first();

            $tabungan_sukarela = DB::table('tb_tabungan_sukarela as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->whereBetween('a.tanggal',[$params['date_start'], $params['date_end']])
                                ->select(
                                    DB::raw('SUM(a.kredit) AS kredit'),
                                    DB::raw('SUM(a.debet) AS debet')
                                )
                                ->first();

                                

            $tabungan_sukarela_bulan_lalu = DB::table('tb_tabungan_sukarela as a')
                                ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                                ->where('a.tanggal','<=', $dtLast->format('Y-m-d'))
                                ->select(
                                    DB::raw('SUM(a.kredit) AS kredit'),
                                    DB::raw('SUM(a.debet) AS debet')
                                )
                                ->first();
            $tabungan_berjangka = DB::table('tb_tabungan_berjangka as a')
                                ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                                ->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
                                ->whereBetween('b.tanggal',[$params['date_start'], $params['date_end']])
                                ->select(
                                    DB::raw('SUM(b.kredit) AS kredit'),
                                    DB::raw('SUM(b.debet) AS debet')
                                )
                                ->first();

            $tabungan_berjangka_bulan_lalu = DB::table('tb_tabungan_berjangka as a')
                                ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
                                ->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
                                ->where('b.tanggal','<=', $dtLast->format('Y-m-d'))
                                ->select(
                                    DB::raw('SUM(b.kredit) AS kredit'),
                                    DB::raw('SUM(b.debet) AS debet')
                                )
                                ->first();


            $data = [
                'params'    => (object) $params,
                'aktiva'    => $data_collect_aktiva,
                'passiva'    => $data_collect_passiva,
                'title'     => 'Laporan Neraca',
                'hutang_nasabah' => $hutang_nasabah->hutang,
                'simpanan_pokok' => $simpanan_pokok->simpanan_pokok + $simpanan_pokok_bulan_lalu->simpanan_pokok,
                'simpanan_wajib' => $simpanan_wajib->simpanan_wajib + $simpanan_wajib_bulan_lalu->simpanan_wajib,
                'piutang_anggota' => DB::table('tb_pinjaman')
                                    ->select(DB::raw('SUM(sisa_pinjaman) AS total'))
                                    ->first(),
                'tabungan_sukarela' => $tabungan_sukarela->kredit -  $tabungan_sukarela->debet + ($tabungan_sukarela_bulan_lalu->kredit - $tabungan_sukarela_bulan_lalu->debet),
                'tabungan_berjangka' => $tabungan_berjangka->kredit -  $tabungan_berjangka->debet + ($tabungan_berjangka_bulan_lalu->kredit -  $tabungan_berjangka_bulan_lalu->debet),
            ];
           
           $pdf = PDF::loadView('laporan.print.cetak_neraca', $data, $params)->setPaper('a4', 'landscape');
           return $pdf->stream($params['date_start'].$params['date_end'].'laporan_neraca.pdf'); 
       }

    
        public function print_arus_kas(Request $request)
        {
            $params         = $request->input('f');
            $simpanan_pokok = DB::table('tb_simpanan_pokok')
                        ->select(DB::raw('SUM(kredit) AS total'))
                        ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                        ->first();
            $simpanan_wajib = DB::table('tb_simpanan_wajib')
                        ->select(DB::raw('SUM(kredit) AS total'))
                        ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                        ->first();
            $tabungan_sukarela = DB::table('tb_tabungan_sukarela as a')
                        ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                        ->select(
                            DB::raw('SUM(a.debet) AS debet'),
                            DB::raw('SUM(a.kredit) AS kredit')
                        )
                        ->whereBetween('tanggal', [$params['date_start'], $params['date_end']])
                        // ->where([
                        //     'b.anggota' => 1,
                        //     'b.berhenti_anggota' => 0
                        // ])
                        ->first();
            $tabungan_berjangka = DB::table('tb_tabungan_berjangka_detail')
                        ->select([  
                            DB::raw('SUM(debet) AS debet'),
                            DB::raw('SUM(kredit) AS kredit')
                        ])
                        ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                        ->first();
            $pengeluaran = DB::table('tb_mutasi_kas')
                        ->select(DB::raw('SUM(total) AS total'))
                        ->where('jenis_mutasi','Pengeluaran')
                        ->whereBetween('tanggal',[$params['date_start'], $params['date_end']])
                        ->where('status_batal',0)
                        ->first();
            $data = [
                'params'                => (object) $params,
                'simpanan_pokok'        => $simpanan_pokok->total,
                'simpanan_wajib'        => $simpanan_wajib->total,
                'tabungan_sukarela'     => $tabungan_sukarela->kredit - $tabungan_sukarela->debet,
                'tabungan_berjangka'    => $tabungan_berjangka->kredit - $tabungan_berjangka->debet,
                'pengeluaran'           => $pengeluaran->total,
                'title'                 => 'Laporan Arus Kas',
            ];

            $pdf = PDF::loadView('laporan.print.cetak_arus_kas', $data, $params)->setPaper('a4', 'landscape');
            return $pdf->stream($params['date_start'].$params['date_end'].'laporan_arus_kas.pdf'); 
        }
     
        private function get_saldo_akhir($akun_id, $date_start, $date_end)
        {
            $item = self::get_buku_besar($akun_id, $date_start, $date_end);

            $debet = 0; $kredit = 0;
            foreach($item as $row) :
                $get_akun = DB::table('tb_akun')->where('id_akun', $akun_id)->first();
                $debet += ($get_akun->normal_pos == 'Debit') ? $row->debet : $row->kredit; 
                $kredit += ($get_akun->normal_pos == 'Kredit') ? $row->debet : $row->kredit; 
                
            endforeach;


            return $debet - $kredit;


        }
         public function print_neraca_lajur(Request $request)
         {
            $params = $request->input('f');

            $akun = DB::table('tb_akun')
                    ->select('*')
                    ->orderBy('id_akun','asc')
                    ->get();

            foreach($akun as $akuns):
                $get_saldo = self::get_buku_besar($akuns->id_akun, $params['date_start'], $params['date_end']);
                $debet = 0; $kredit = 0;$saldo_akhir = 0;
                    foreach($get_saldo as $row):
                        $debet += $row->debet; 
                        $kredit += $row->kredit; 
                        $saldo_akhir = ( $row->debet > 0) ? $saldo_akhir + $row->debet : $saldo_akhir - $row->kredit;
                    endforeach;

                //GET SALDO AKHIR BULAN LALU
                $dateBeforeFirst = $params['date_start'].'first day of last month';
                $dtFirst = date_create($dateBeforeFirst);
                $dateBeforeLast = $params['date_start'].'last day of last month';
                $dtLast = date_create($dateBeforeLast);

                $collection_saldo_sebelumnya = self::get_buku_besar_saldo_awal($akuns->id_akun, $dtLast->format('Y-m-d'));
                $debet = 0; $kredit = 0;$saldo_akhir_bulan_lalu = 0;
                if(!empty($collection_saldo_sebelumnya)) :
                    foreach($collection_saldo_sebelumnya as $row):
                        $debet += $row->debet; 
                        $kredit += $row->kredit; 
                        $saldo_akhir_bulan_lalu = ( $row->debet > 0) ? $saldo_akhir_bulan_lalu + $row->debet : $saldo_akhir_bulan_lalu - $row->kredit;
                    endforeach;
                endif;

                $data_akun[] = [
                    'normal_pos' => $akuns->normal_pos,
                    'golongan' => $akuns->golongan,
                    'id_akun'   => $akuns->id_akun,
                    'nama_akun' => $akuns->nama_akun,
                    // 'debet_neraca_saldo' => ($akuns->normal_pos == 'Debit') ? self::get_saldo_akhir($akuns->id_akun, $params['date_start'], $params['date_end']) : 0,
                    // 'kredit_neraca_saldo' =>  ($akuns->normal_pos == 'Kredit') ? self::get_saldo_akhir($akuns->id_akun, $params['date_start'], $params['date_end']) : 0,
                    'debet_neraca_saldo' => ($akuns->normal_pos == 'Debit') ? $saldo_akhir + $saldo_akhir_bulan_lalu +  $akuns->saldo_awal : 0,
                    'kredit_neraca_saldo' =>  ($akuns->normal_pos == 'Kredit') ? $saldo_akhir + $saldo_akhir_bulan_lalu +  $akuns->saldo_awal : 0,
                ]; 
            endforeach;

            $debet1 = 0; $kredit1 = 0;
            foreach($data_akun as $row):
                $debet1  += $row['debet_neraca_saldo']; 
                $kredit1 += $row['kredit_neraca_saldo'];
            endforeach;

            $balance = $debet1 - $kredit1;

             $data = [
                 'params'            => (object) $params,
                 'akun'        => $data_akun,
                 'title'             => 'Laporan Neraca Lajur',
                 'balance'     => $balance
             ];
 
             $pdf = PDF::loadView('laporan.print.cetak_neraca_lajur', $data, $params)->setPaper('a4', 'landscape');
             return $pdf->stream($params['date_start'].$params['date_end'].'laporan_neraca_lajur.pdf'); 
         }
  
}