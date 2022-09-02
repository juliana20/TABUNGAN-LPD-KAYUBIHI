<?php

namespace App\Http\Controllers;

use App\Http\Model\Akun_m;
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
                    ->where('t_jurnal_umum.status_batal', 0)
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

       public function bukuBesar()
       {
                $item = [
                    'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                    'date_end'   => Carbon::now()->endOfMonth()->toDateString()
                ];
    
                $data = array(
                    'item'              => (object) $item,
                    'title'             => 'Laporan Buku Besar',
                    'url_print'         => 'laporan/buku-besar/print'
                );
    
                return view('laporan.form.buku_besar', $data);
    
        }
  
        public function printBukuBesar(Request $request)
        {

            $params = $request->input('f');
            $get_akun = Akun_m::where('id', $params['akun_id'])->first();
            //GET SALDO AKHIR BULAN LALU
            $dateBeforeLast = $params['date_start'].'last day of last month';
            $dtLast = date_create($dateBeforeLast);

            $collection_saldo_sebelumnya = self::get_buku_besar_saldo_awal($params['akun_id'], $dtLast->format('Y-m-d'));
            $debet = 0; 
            $kredit = 0; 
            $saldo_akhir_bulan_lalu = 0;
            if(!empty($collection_saldo_sebelumnya)) :
                foreach($collection_saldo_sebelumnya as $row):
                    $debet += $row->debet; 
                    $kredit += $row->kredit; 
                    //jika akun pendapatan
                    if(in_array($params['akun_id'], [5, 6, 7]) || $get_akun->kelompok == 'Aktiva Tetap')
                    {
                        $saldo_akhir_bulan_lalu = ( $row->debet > 0) ? $saldo_akhir_bulan_lalu - $row->debet : $saldo_akhir_bulan_lalu + $row->kredit;
                    }else{
                        $saldo_akhir_bulan_lalu = ( $row->debet > 0) ? $saldo_akhir_bulan_lalu + $row->debet : $saldo_akhir_bulan_lalu - $row->kredit;
                    }
                endforeach;
            endif;

            $data = [
                'params'       => (object) $params,
                'item'         => self::get_buku_besar($params['akun_id'], $params['date_start'], $params['date_end']),
                'title'        => 'Laporan Buku Besar',
                'akun'         => $get_akun,
                'saldo_akhir_bulan_lalu' => $saldo_akhir_bulan_lalu,
                'saldo_awal'   => $get_akun->saldo_awal
            ];

            $pdf = PDF::loadView('laporan.print.cetak_buku_besar', $data, $params)->setPaper('a4', 'landscape');
            return $pdf->stream($params['date_start'].$params['date_end'].'laporan_buku_besar.pdf'); 
        }

        private function get_buku_besar($id_akun, $date_start, $date_end)
        {
            $query = Jurnal_umum_m::whereBetween('tanggal', [$date_start, $date_end])
                        ->where('status_batal', 0)
                        ->where('akun_id', $id_akun)
                        ->orderBy('tanggal','ASC')
                        ->get();

            return $query;
        }

        
        private function get_buku_besar_saldo_awal($id_akun, $date)
        {
            $query = Jurnal_umum_m::where('tanggal','<=', $date)
                                    ->where('status_batal', 0)
                                    ->where('akun_id', $id_akun)
                                    ->orderBy('tanggal','ASC')
                                    ->get();

            return $query;
        }

        public function neraca()
        {
            $item = [
                'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                'date_end'   => Carbon::now()->endOfMonth()->toDateString()
            ];

            $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Neraca',
                'url_print'         => 'laporan/neraca/print'
            );

            return view('laporan.form.neraca', $data);
    
        }

        public function printNeraca(Request $request)
        {
            $params = $request->input('f');

            $aktiva = Akun_m::where('golongan', 'Aktiva')->get();
            $passiva = Akun_m::whereIn('golongan', ['Hutang','Modal'])->get();

            $collection_aktiva = [];
            $data_collect_aktiva = [];
            foreach($aktiva as $aktv):
                $get_saldo = self::get_buku_besar($aktv->id, $params['date_start'], $params['date_end']);
                $debet = 0; 
                $kredit = 0;
                $saldo_akhir = 0;
            foreach($get_saldo as $row):
                $debet += $row->debet; 
                $kredit += $row->kredit; 
                $saldo_akhir = ( $row->debet > 0) ? $saldo_akhir + $row->debet : $saldo_akhir - $row->kredit;
            endforeach;

            //GET SALDO AKHIR BULAN LALU
            $dateBeforeFirst = $params['date_start'].'first day of last month';
            $dateBeforeLast = $params['date_start'].'last day of last month';
            $dtLast = date_create($dateBeforeLast);

                $collection_saldo_sebelumnya = self::get_buku_besar_saldo_awal($aktv->id, $dtLast->format('Y-m-d'));
                $debet = 0; 
                $kredit = 0;
                $saldo_akhir_bulan_lalu = 0;
                if(!empty($collection_saldo_sebelumnya)) :
                    foreach($collection_saldo_sebelumnya as $row):
                        $debet += $row->debet; 
                        $kredit += $row->kredit; 
                        $saldo_akhir_bulan_lalu = ( $row->debet > 0 ) ? $saldo_akhir_bulan_lalu + $row->debet : $saldo_akhir_bulan_lalu - $row->kredit;
                    endforeach;
                endif;


                $collection_aktiva = [
                    'id' => $aktv->id,
                    'kode_akun' => $aktv->kode_akun,
                    'nama_akun' => $aktv->nama_akun,
                    'normal_pos' => $aktv->normal_pos,
                    'nilai' => ( $saldo_akhir > 0) ? $saldo_akhir + $saldo_akhir_bulan_lalu + $aktv->saldo_awal : $saldo_akhir + $aktv->saldo_awal,
                ];

                $data_collect_aktiva[$aktv->kelompok][] = $collection_aktiva;

            endforeach;

            $collection_passiva = [];
            $data_collect_passiva = [];
            foreach($passiva as $pass):
                $collection_passiva = [
                'id' => $pass->id,
                'kode_akun' => $pass->kode_akun,
                'nama_akun' => $pass->nama_akun,
                'nilai' => self::get_summary($pass->id, $params['date_start'], $params['date_end']) + $pass->saldo_awal,
                ];

                $data_collect_passiva[$pass->kelompok][] = $collection_passiva;

            endforeach;
            //GET SALDO AKHIR BULAN LALU
            $dateBeforeFirst = $params['date_start'].'first day of last month';
            $dtFirst = date_create($dateBeforeFirst);
            $dateBeforeLast = $params['date_start'].'last day of last month';
            $dtLast = date_create($dateBeforeLast);
 

            $data = [
                'params'    => (object) $params,
                'aktiva'    => $data_collect_aktiva,
                'passiva'    => $data_collect_passiva,
                'title'     => 'Laporan Neraca',
            ];

            $pdf = PDF::loadView('laporan.print.cetak_neraca', $data, $params)->setPaper('a4', 'landscape');
            return $pdf->stream($params['date_start'].$params['date_end'].'laporan_neraca.pdf'); 
        }

        
       private function get_summary($id_akun, $date_start, $date_end)
       {
            $query = Jurnal_umum_m::whereBetween('tanggal', [$date_start, $date_end])
                        ->where('status_batal', 0)
                        ->select([
                            DB::raw('SUM(debet) AS debet'),
                            DB::raw('SUM(kredit) AS kredit'),
                        ])
                        ->where([
                            'akun_id' => $id_akun,
                        ])
                        ->first();

        
        return $query->debet - $query->kredit;
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