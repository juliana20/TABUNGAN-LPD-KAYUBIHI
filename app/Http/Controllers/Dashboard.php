<?php

namespace App\Http\Controllers;

use App\Http\Model\Akun_m;
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

    private function totalPengeluaran($bulan, $year)
    {
        
        $pengeluaran = Akun_m::join('t_jurnal_umum','t_jurnal_umum.akun_id','m_akun.id')
                        ->where([
                            'm_akun.golongan' => 'Biaya',
                            't_jurnal_umum.status_batal' => 0
                        ])
                        ->where(DB::raw('YEAR(t_jurnal_umum.tanggal)'), $year)
                        ->where(DB::raw('MONTH(t_jurnal_umum.tanggal)'), $bulan)
                        ->select(DB::raw('sum(t_jurnal_umum.debet) as total'))
                        ->first();

        $total = $pengeluaran->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPembayaranOnline($bulan, $year)
    {
        
        $pemasukan = Akun_m::join('t_jurnal_umum','t_jurnal_umum.akun_id','m_akun.id')
                        ->where([
                            'm_akun.id' => '6',
                            't_jurnal_umum.status_batal' => 0
                        ])
                        ->where(DB::raw('YEAR(t_jurnal_umum.tanggal)'), $year)
                        ->where(DB::raw('MONTH(t_jurnal_umum.tanggal)'), $bulan)
                        ->select(DB::raw('sum(t_jurnal_umum.kredit) as total'))
                        ->first();

        $total = $pemasukan->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPembayaranSampah($bulan, $year)
    {
        
        $pemasukan = Akun_m::join('t_jurnal_umum','t_jurnal_umum.akun_id','m_akun.id')
                        ->where([
                            'm_akun.id' => '5',
                            't_jurnal_umum.status_batal' => 0
                        ])
                        ->where(DB::raw('YEAR(t_jurnal_umum.tanggal)'), $year)
                        ->where(DB::raw('MONTH(t_jurnal_umum.tanggal)'), $bulan)
                        ->select(DB::raw('sum(t_jurnal_umum.kredit) as total'))
                        ->first();

        $total = $pemasukan->total;
        return ($total > 0) ? $total : 0;
    } 

    private function totalPembayaranSamsat($bulan, $year)
    {
        
        $pemasukan = Akun_m::join('t_jurnal_umum','t_jurnal_umum.akun_id','m_akun.id')
                        ->where([
                            'm_akun.id' => '7',
                            't_jurnal_umum.status_batal' => 0
                        ])
                        ->where(DB::raw('YEAR(t_jurnal_umum.tanggal)'), $year)
                        ->where(DB::raw('MONTH(t_jurnal_umum.tanggal)'), $bulan)
                        ->select(DB::raw('sum(t_jurnal_umum.kredit) as total'))
                        ->first();

        $total = $pemasukan->total;
        return ($total > 0) ? $total : 0;
    } 


    public function chartPengeluaran(Request $request)
    {
        $params = $request->post('header');
        $months = array(
            ['id' => 1,'bulan' => 'Januari'], 
            ['id' => 2,'bulan' => 'Februari'], 
            ['id' => 3,'bulan' => 'Maret'], 
            ['id' => 4,'bulan' => 'April'], 
            ['id' => 5,'bulan' => 'Mei'], 
            ['id' => 6,'bulan' => 'Juni'], 
            ['id' => 7,'bulan' => 'Juli'], 
            ['id' => 8,'bulan' => 'Agustus'], 
            ['id' => 9,'bulan' => 'September'], 
            ['id' => 10,'bulan' => 'Oktober'], 
            ['id' => 11,'bulan' => 'November'], 
            ['id' => 12,'bulan' => 'Desember'], 
        );

        $grafik = [];
        $total_pengeluaran = 0;
        foreach($months as $bln):
            $total_pengeluaran += self::totalPengeluaran($bln['id'], $params['year_pengeluaran']);
            $grafik[] = [
                'Bulan' => $bln['bulan'],
                'Pengeluaran' => self::totalPengeluaran($bln['id'], $params['year_pengeluaran']),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_pengeluaran" => "Rp.". number_format($total_pengeluaran, 2),
            "code" => "200",
        );
        return Response::json($response);
    }

    public function chartPemasukan(Request $request)
    {
        $params = $request->post('header');
        $months = array(
            ['id' => 1,'bulan' => 'Januari'], 
            ['id' => 2,'bulan' => 'Februari'], 
            ['id' => 3,'bulan' => 'Maret'], 
            ['id' => 4,'bulan' => 'April'], 
            ['id' => 5,'bulan' => 'Mei'], 
            ['id' => 6,'bulan' => 'Juni'], 
            ['id' => 7,'bulan' => 'Juli'], 
            ['id' => 8,'bulan' => 'Agustus'], 
            ['id' => 9,'bulan' => 'September'], 
            ['id' => 10,'bulan' => 'Oktober'], 
            ['id' => 11,'bulan' => 'November'], 
            ['id' => 12,'bulan' => 'Desember'], 
        );

        $grafik = [];
        $total_pemasukan = 0;
        foreach($months as $bln):
            $total_pemasukan += self::totalPembayaranOnline($bln['id'], $params['year_pemasukan']) + self::totalPembayaranSamsat($bln['id'], $params['year_pemasukan']) + self::totalPembayaranSampah($bln['id'], $params['year_pemasukan']);
            $grafik[] = [
                'Bulan' => $bln['bulan'],
                'Online' => self::totalPembayaranOnline($bln['id'], $params['year_pemasukan']),
                'Samsat' => self::totalPembayaranSamsat($bln['id'], $params['year_pemasukan']),
                'Sampah' => self::totalPembayaranSampah($bln['id'], $params['year_pemasukan']),
            ];
        endforeach;

        $response = array(
            "data" => $grafik,
            "status" => "success",
            "message" => 'Grafik',
            "total_pemasukan" => "Rp.". number_format($total_pemasukan, 2),
            "code" => "200",
        );
        return Response::json($response);
    }


    
}
