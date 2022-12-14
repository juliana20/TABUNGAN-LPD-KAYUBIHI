<?php

namespace App\Http\Controllers;

use App\Http\Model\Nasabah_m;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Response;
use DB;
use Helpers;

class Dashboard extends Controller
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

    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'     => 'Beranda',
            'bulan'     => $this->bulan
        ];

        if(Helpers::getJabatan() == 'Nasabah')
        {
            $nasabah = Nasabah_m::where('user_id', Helpers::getId())->first();
            $data['get_saldo'] = Tabungan_m::where('nasabah_id', $nasabah->id)->first()->saldo;
            return view('dashboard.dashboard_nasabah', $data);
        }else{
            return view('dashboard.dashboard', $data);
        }

 
    }

    private function totalSimpanan($bulan, $year)
    {
        if(Helpers::getJabatan() == 'Nasabah')
        {
            $get_nasabah = Nasabah_m::join('m_tabungan','m_tabungan.nasabah_id','m_nasabah.id')
                            ->where('user_id', Helpers::getId())
                            ->select('m_nasabah.*','m_tabungan.id as tabungan_id')
                            ->first();
        }
        $simpanan = Simpan_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_setoran) as total'));

        if(!empty($get_nasabah)){
            $simpanan->where('tabungan_id', $get_nasabah->tabungan_id);
        }

        $total = $simpanan->first()->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPenarikan($bulan, $year)
    {
        if(Helpers::getJabatan() == 'Nasabah')
        {
            $get_nasabah = Nasabah_m::join('m_tabungan','m_tabungan.nasabah_id','m_nasabah.id')
                            ->where('user_id', Helpers::getId())
                            ->select('m_nasabah.*','m_tabungan.id as tabungan_id')
                            ->first();
        }

        $penarikan = Tarik_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_penarikan) as total'));

        if(!empty($get_nasabah)){
            $penarikan->where('tabungan_id', $get_nasabah->tabungan_id);
        }

        $total = $penarikan->first()->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalSimpananHarian($day, $bulan, $year)
    {
        if(Helpers::getJabatan() == 'Nasabah')
        {
            $get_nasabah = Nasabah_m::join('m_tabungan','m_tabungan.nasabah_id','m_nasabah.id')
                            ->where('user_id', Helpers::getId())
                            ->select('m_nasabah.*','m_tabungan.id as tabungan_id')
                            ->first();
        }

        $simpanan = Simpan_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('DAY(tanggal)'), $day)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_setoran) as total'));

        if(!empty($get_nasabah)){
            $simpanan->where('tabungan_id', $get_nasabah->tabungan_id);
        }
        $total = $simpanan->first()->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPenarikanHarian($day, $bulan, $year)
    {
        if(Helpers::getJabatan() == 'Nasabah')
        {
            $get_nasabah = Nasabah_m::join('m_tabungan','m_tabungan.nasabah_id','m_nasabah.id')
                            ->where('user_id', Helpers::getId())
                            ->select('m_nasabah.*','m_tabungan.id as tabungan_id')
                            ->first();
        }
        $penarikan = Tarik_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('DAY(tanggal)'), $day)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_penarikan) as total'));

        if(!empty($get_nasabah)){
            $penarikan->where('tabungan_id', $get_nasabah->tabungan_id);
        }
        $total = $penarikan->first()->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalNasabah($bulan, $year)
    {
        
        $query = Nasabah_m::where(DB::raw('YEAR(tanggal_daftar)'), $year)
                        ->where(DB::raw('MONTH(tanggal_daftar)'), $bulan);

        $total = $query->count();
        return ($total > 0) ? $total : 0;
    } 


    public function chartSimpanan(Request $request)
    {
        $params = $request->post('header');

        $grafik = [];
        $total = 0;
        foreach($this->bulan as $bln):
            $total += self::totalSimpanan($bln['id'], $params['year_simpanan']);
            $grafik[] = [
                'Bulan' => $bln['desc'],
                'Simpanan' => self::totalSimpanan($bln['id'], $params['year_simpanan']),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_simpanan" => "Rp.". number_format($total, 2),
            "code" => "200",
        );
        return Response::json($response);
    }

    public function chartPenarikan(Request $request)
    {
        $params = $request->post('header');

        $grafik = [];
        $total = 0;
        foreach($this->bulan as $bln):
            $total += self::totalPenarikan($bln['id'], $params['year_penarikan']);
            $grafik[] = [
                'Bulan' => $bln['desc'],
                'Penarikan' => self::totalPenarikan($bln['id'], $params['year_penarikan']),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_penarikan" => "Rp.". number_format($total, 2),
            "code" => "200",
        );
        return Response::json($response);
    }

    public function chartTransaksiHarian(Request $request)
    {
        $params = $request->post('header');

        $start  = new DateTime(date("{$params['year_harian']}-{$params['month_transaksi']}-d"));
        $start->modify('first day of this month');
        $end    = new DateTime(date("{$params['year_harian']}-{$params['month_transaksi']}-d"));
        $end->modify('last day of this month');

        $interval = DateInterval::createFromDateString('1 day');
        $period   = new DatePeriod($start, $interval, $end);

        $grafik = [];
        $total_simpanan = 0;
        $total_penarikan = 0;
        foreach ($period as $dt) {
            $total_simpanan += self::totalSimpananHarian($dt->format("d"), $params['month_transaksi'], $params['year_harian']);
            $total_penarikan += self::totalPenarikanHarian($dt->format("d"), $params['month_transaksi'], $params['year_harian']);
            $grafik[] = [
                'Day' => $dt->format("d"),
                'Simpanan' => self::totalSimpananHarian($dt->format("d"), $params['month_transaksi'], $params['year_harian']),
                'Penarikan' => self::totalPenarikanHarian($dt->format("d"), $params['month_transaksi'], $params['year_harian']),
            ];
        }

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_transaksi_harian_simpanan" => "Rp.". number_format($total_simpanan, 2),
            "total_transaksi_harian_penarikan" => "Rp.". number_format($total_penarikan, 2),
            "code" => "200",
        );
        return Response::json($response);
    }

    public function chartNasabah(Request $request)
    {
        $params = $request->post('header');

        $grafik = [];
        $total = 0;
        foreach($this->bulan as $bln):
            $total += self::totalNasabah($bln['id'], $params['year_nasabah']);
            $grafik[] = [
                'Bulan' => $bln['desc'],
                'Nasabah' => self::totalNasabah($bln['id'], $params['year_nasabah']),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_nasabah" => $total,
            "code" => "200",
        );
        return Response::json($response);
    }

    private function totalTabunganNasabah($nasabah_id)
    {
        $query = Tabungan_m::where('nasabah_id', $nasabah_id);
        $total = $query->first()->saldo;
        return ($total > 0) ? $total : 0;
    } 

    public function chartNasabahTabunganTerbanyak(Request $request)
    {
        $nasabah = Nasabah_m::join('m_tabungan','m_nasabah.id','m_tabungan.nasabah_id')
                    ->select('m_nasabah.*','m_tabungan.nasabah_id','m_tabungan.no_rekening')
                    ->take(10)
                    ->get();

        $grafik = [];
        $total = 0;
        foreach($nasabah as $row):
            $total += self::totalTabunganNasabah($row->id);
            $grafik[] = [
                'Nasabah' => $row->nama_nasabah,
                'Tabungan' => self::totalTabunganNasabah($row->id),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total" => 'Rp.' . number_format($total,2),
            "code" => "200",
        );
        return Response::json($response);
    }


    
}
