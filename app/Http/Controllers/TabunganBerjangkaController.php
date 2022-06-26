<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Tabungan_berjangka_m;
use App\Http\Model\Tabungan_berjangka_detail_m;
use App\Http\Model\Akun_m;
use App\Http\Model\Nasabah_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use Helpers;
use DB;
use Response;
use PDF;
use DateTime;
use DatePeriod;
use DateInterval;

class TabunganBerjangkaController extends Controller
{
    
    protected $option_jangka_waktu = [
        ['id' => '365','value' => '1', 'bulan' => '12', 'desc' => '1 Tahun'],
        ['id' => '730','value' => '2','bulan' => '24', 'desc' => '2 Tahun'],
        ['id' => '1095.75','value' => '3', 'bulan' => '36','desc' => '3 Tahun'],
        ['id' => '1461','value' => '4', 'bulan' => '48','desc' => '4 Tahun'],
        ['id' => '1826.25','value' => '5', 'bulan' => '60','desc' => '5 Tahun'],
        ['id' => '2191.5','value' => '6', 'bulan' => '72','desc' => '6 Tahun'],
        ['id' => '2556.75','value' => '7', 'bulan' => '84','desc' => '7 Tahun'],
        ['id' => '2922','value' => '8', 'bulan' => '96','desc' => '8 Tahun'],
        ['id' => '3287.25','value' => '9', 'bulan' => '108','desc' => '9 Tahun'],
        ['id' => '3652.5','value' => '10', 'bulan' => '120','desc' => '10 Tahun'],
    ];
    public function __construct()
    {
        $this->model = New Tabungan_berjangka_m;
        $this->model_detail = New Tabungan_berjangka_detail_m;
        $this->model_akun = New Akun_m;
        $this->model_nasabah = New Nasabah_m;
        $this->nameroutes = 'tabungan-berjangka';
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
            'title'             => 'Data Tabungan Berjangka',
            'breadcrumb'        => 'List Data Tabungan Berjangka',
            'headerModalTambah' => 'TAMBAH DATA TABUNGAN BERJANGKA',
            'headerModalEdit'   => 'UBAH DATA TABUNGAN BERJANGKA',
        );
        return view('tabungan_berjangka.datatable',$data);
    }

    public function list_setoran()
    {
         $data = array(
             'nameroutes'        => $this->nameroutes,
             'title'             => 'Data Setoran & Penarikan Tabungan Berjangka',
             'breadcrumb'        => 'List Data Setoran & Penarikan Tabungan Berjangka',
         );
         return view('tabungan_berjangka.datatable.setoran',$data);
     }
     public function list_penarikan()
     {
          $data = array(
              'nameroutes'        => $this->nameroutes,
              'title'             => 'Data Penarikan Tabungan Berjangka',
              'breadcrumb'        => 'List Data Penarikan Tabungan Berjangka',
          );
          return view('tabungan_berjangka.datatable.penarikan',$data);
      }

    public function create(Request $request)
    {
        $item = [
            'id_tabungan_berjangka' => $this->model->gen_no_bukti_deposito('TD'),
            'tanggal_awal' => date('Y-m-d'),
            'bunga_tabungan_berjangka' => '0.5'
        ];
        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_akun'           => $this->model_akun->get_all(),
            'nameroutes'            => $this->nameroutes,
            'option_jangka_waktu'   => $this->option_jangka_waktu
        );

        //jika form sumbit
        if($request->post())
        {
            $data_post = $request->input('f');
            $data_post['id_tabungan_berjangka'] = $this->model->gen_no_bukti_deposito('TD');
            $data_post['id_user'] = Helpers::getId();

            $details= [
                'id_tabungan_berjangka' => $data_post['id_tabungan_berjangka'],
                'tanggal' => date('Y-m-d'),
                'debet' => 0,
                'kredit' => $data_post['nominal_tabungan_berjangka'],
                'id_user' => Helpers::getId(),
                'id_akun'  => '10101'
            ];

            DB::beginTransaction();
            try {
                $this->model->insert_data($data_post);
                $this->model->insert_data_detail($details);
                DB::commit();
    
                $response = [
                    "message" => 'Tabungan berjangka berhasil dibuat',
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

        return view('tabungan_berjangka.form', $data);

    }

    public function lookup_form_setoran(Request $request, $id)
    {
        $get_data = DB::table("tb_tabungan_berjangka as a")
                    ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                    ->where('a.id_tabungan_berjangka', $id)
                    ->select('a.*','b.nama_nasabah')
                    ->first();

        $data = [
            'title'         => 'Setoran Tabungan Berjangka',
            'item'          => $get_data,
            'submit_url'    => $this->nameroutes.'/simpan-tabungan-berjangka',
            'is_edit'       => FALSE,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_tabungan_berjangka),
            'option_akun'   => $this->model_akun->get_all()    
        ];

        return view('tabungan_berjangka.lookup.setoran', $data);
    }

    public function lookup_form_penarikan(Request $request, $id)
    {
        $get_data = DB::table("tb_tabungan_berjangka as a")
                    ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                    ->where('a.id_tabungan_berjangka', $id)
                    ->select('a.*','b.nama_nasabah')
                    ->first();

        $data = [
            'title'         => 'Penarikan Tabungan',
            'item'          => $get_data,
            'submit_url'    => $this->nameroutes.'/simpan-tabungan-berjangka',
            'is_edit'       => FALSE,
            'nameroutes'    => $this->nameroutes,
            'saldo_real'         => self::get_saldo($get_data->id_tabungan_berjangka),
            'saldo'         => ($get_data->jatuh_tempo > date('Y-m-d')) ? self::get_saldo($get_data->id_tabungan_berjangka) - (self::get_saldo($get_data->id_tabungan_berjangka) * 1 /100) : self::get_saldo($get_data->id_tabungan_berjangka) + $get_data->total_bunga,
            'option_akun'   => $this->model_akun->get_all()    
        ];

        return view('tabungan_berjangka.lookup.penarikan', $data);
    }

    
    public function simpan_tabungan_berjangka(Request $request)
    {
            //jika form sumbit
            if($request->post())
            {
                $header = $request->input('f');
                $header['id_user'] = Helpers::getId();
    
                DB::beginTransaction();
                try {
                    if(!empty($header['debet'])){
                        $denda = $request->input('g');
                        $this->model->update_data([
                            'denda_pinalti' =>  $denda['denda_pinalti'],
                            'status_tabungan_berjangka' => 0
                        ], $header['id_tabungan_berjangka']);
                        $this->model->insert_data_detail($header);
                    }else{
                        $this->model->insert_data_detail($header);
                    }

                    DB::commit();
        
                    $response = [
                        "message" => 'Tabungan berjangka berhasil dibuat',
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    }

    private function get_saldo($id)
    {
        // $debet  = $this->model->get_debet_tabungan_berjangka($id);
        $kredit = $this->model->get_kredit_tabungan_berjangka($id);
        $saldo  = $kredit;

        return $saldo;
    }
    public function detail(Request $request, $id)
    {
        $get_data = DB::table("tb_tabungan_berjangka as a")
                    ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
                    ->where('a.id_tabungan_berjangka', $id)
                    ->select('a.*','b.nama_nasabah')
                    ->first();
        $count_setoran = DB::table('tb_tabungan_berjangka_detail')
                            ->where('id_tabungan_berjangka', $id)
                            ->where('kredit','<>', 0)
                            ->where('debet','=', 0)
                            ->get();

        $data = [
            'title'         => 'Detail Tabungan Berjangka',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_tabungan_berjangka),
            'sisa_setoran'  => ($get_data->jangka_waktu_bulan - count($count_setoran)) * $get_data->nominal_tabungan_berjangka,
            'sisa_bulan'  => ($get_data->jangka_waktu_bulan - count($count_setoran)),
            'collection'    => $this->model->get_collection($get_data->id_tabungan_berjangka),
            'submit_url'    => url()->current(),   
        ];
        
        return view('tabungan_berjangka.detail', $data);
    }

    public function proses_setoran(Request $request, $id)
    {
        $get_data = $this->model_detail->get_one($id);

        $data = [
            'title'         => 'Proses Setoran & Penarikan Tabungan Berjangka',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_tabungan_berjangka),
            'collection'    => $this->model->get_collection($get_data->id_tabungan_berjangka),
            'submit_url'    => url()->current(),   
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            // $header = $request->input('f');
            //insert data
            DB::beginTransaction();
            try {
                $this->model_detail->update_by(['proses' => 1],['id' => $id]);
                DB::commit();

                $response = [
                    "message" => 'Tabungan berjangka berhasil di proses',
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
        
        return view('tabungan_berjangka.form.proses_setoran', $data);
    }

    
    public function proses_penarikan(Request $request, $id)
    {
        $get_data = $this->model_detail->get_one($id);

        $data = [
            'title'         => 'Proses Penarikan Tabungan Berjangka',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_tabungan_berjangka),
            'collection'    => $this->model->get_collection($get_data->id_tabungan_berjangka),
            'submit_url'    => url()->current(),   
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            // $header = $request->input('f');
            //insert data
            DB::beginTransaction();
            try {
                $this->model_detail->update_by(['proses' => 1],['id' => $id]);
                DB::commit();

                $response = [
                    "message" => 'Penarikan tabungan berjangka berhasil di proses',
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
        
        return view('tabungan_berjangka.form.proses_penarikan', $data);
    }

    public function cetak_tabungan($id)
    {
        $get_data = $this->model_detail->get_one($id);
        $data = [
            'label' => ($get_data->debet == 0 || $get_data->debet == '') ? 'Jumlah Setor' : 'Jumlah Penarikan',
            // 'saldo' => self::get_saldo($get_data->id_tabungan_berjangka),
            'saldo' => $get_data->saldo_akhir,
            'item'  => $get_data,
            'title' => ($get_data->debet == 0 || $get_data->debet == '') ? 'Bukti Setoran Tabungan Berjangka' : 'Bukti Penarikan Tabungan Berjangka',
        ];

        // return view('laporan.print.kategori_keuangan', $data);
        $pdf = PDF::loadView('tabungan_berjangka.print.cetak_bukti_tabungan', $data)->setPaper('a5', 'portait');
        return $pdf->stream(($get_data->debet == 0 || $get_data->debet == '') ? 'Bukti Setoran Tabungan' : 'Bukti Penarikan Tabungan'.'.pdf'); 
    }

    public function datatables_collection()
    {
        $params = request()->all();
        $data = $this->model->get_all($params);
        return Datatables::of($data)->make(true);
    }

        
    public function datatables_collection_tabungan_berjangka()
    {
        $params = request()->all();
        $data = $this->model->get_all_tabungan_berjangka($params);
        return Datatables::of($data)->make(true);
    }

    public function tabungan_nasabah()
    {
         $data = array(
             'nameroutes'        => $this->nameroutes,
             'title'             => 'Data Tabungan Berjangka Nasabah',
             'breadcrumb'        => 'List Data Tabungan Berjangka',
             'urlDatatables'     => 'nasabah/tabungan-berjangka/datatables',
         );
         return view('tabungan_berjangka.nasabah.datatable',$data);
     }


    public function datatables_collection_nasabah()
    {
        $params = request()->all();
        $data = $this->model->get_all_tabungan_nasabah($params);
        return Datatables::of($data)->make(true);
    }

    public function simulasi(Request $request, $bunga_tabungan_berjangka, $jangka_waktu, $nominal_tabungan_berjangka, $total_tabungan_berjangka, $tanggal_awal, $jatuh_tempo, $jumlah_bulan)
    {
        $total_bunga = ($nominal_tabungan_berjangka * $bunga_tabungan_berjangka) * $jangka_waktu;
        $item = [
            'bunga_tabungan_berjangka' => $bunga_tabungan_berjangka,
            'jangka_waktu' => $jangka_waktu,
            'nominal_tabungan_berjangka' =>  $nominal_tabungan_berjangka,
            'total_tabungan_berjangka' => $total_tabungan_berjangka,
            'tanggal_awal' => $tanggal_awal,
            'jatuh_tempo' => $jatuh_tempo,
            'total_bunga' => $total_bunga
        ];

        $start    = new DateTime( $tanggal_awal);
        $start->modify('first day of this month');
        $end      = new DateTime($jatuh_tempo);
        $end->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $date1 = strtotime($tanggal_awal);
        $date2 = strtotime($jatuh_tempo);
        $months = 0;
        
        while (($date1 = strtotime('+1 MONTH', $date1)) <= $date2)
            $months++;


        $saldo_akhir = 0;
        foreach ($period as $dt) {
            $saldo_akhir = $saldo_akhir + $nominal_tabungan_berjangka + ($total_bunga / $jumlah_bulan);
            $collections[] = [
                'periode'       => $dt->format("M Y"),
                'bunga'         => $total_bunga / $jumlah_bulan,
                'setoran'       => round($nominal_tabungan_berjangka),
                'saldo_akhir'   =>  round($saldo_akhir) ,
            ];
        }

        $data = array(
            'item'                  => (object) $item,
            'collections'             => $collections
        );

        return view('tabungan_berjangka.simulasi', $data);

    }

}
