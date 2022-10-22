<?php

namespace App\Http\Controllers;

use App\Http\Model\Nasabah_m;
use App\Http\Model\Simpan_tabungan_m;
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
        return view('dashboard.dashboard', $data);
 
    }

    private function totalSimpanan($bulan, $year)
    {
        
        $simpanan = Simpan_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_setoran) as total'))
                        ->first();

        $total = $simpanan->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPenarikan($bulan, $year)
    {
        
        $penarikan = Tarik_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_penarikan) as total'))
                        ->first();

        $total = $penarikan->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalSimpananHarian($day, $bulan, $year)
    {
        
        $simpanan = Simpan_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('DAY(tanggal)'), $day)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_setoran) as total'))
                        ->first();

        $total = $simpanan->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPenarikanHarian($day, $bulan, $year)
    {
        
        $penarikan = Tarik_tabungan_m::where(DB::raw('YEAR(tanggal)'), $year)
                        ->where(DB::raw('DAY(tanggal)'), $day)
                        ->where(DB::raw('MONTH(tanggal)'), $bulan)
                        ->select(DB::raw('sum(nominal_penarikan) as total'))
                        ->first();

        $total = $penarikan->total;
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

        $start  = new DateTime(date("Y-{$params['month_transaksi']}-d"));
        $start->modify('first day of this month');
        $end    = new DateTime(date("Y-{$params['month_transaksi']}-d"));
        $end->modify('last day of this month');

        $interval = DateInterval::createFromDateString('1 day');
        $period   = new DatePeriod($start, $interval, $end);

        $grafik = [];
        $total_simpanan = 0;
        $total_penarikan = 0;
        foreach ($period as $dt) {
            $total_simpanan += self::totalSimpananHarian($dt->format("d"), $params['month_transaksi'], date('Y'));
            $total_penarikan += self::totalPenarikanHarian($dt->format("d"), $params['month_transaksi'], date('Y'));
            $grafik[] = [
                'Day' => $dt->format("d"),
                'Simpanan' => self::totalSimpananHarian($dt->format("d"), $params['month_transaksi'], date('Y')),
                'Penarikan' => self::totalPenarikanHarian($dt->format("d"), $params['month_transaksi'], date('Y')),
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


    
}
