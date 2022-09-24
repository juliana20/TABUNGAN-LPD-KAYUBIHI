<?php

namespace App\Http\Controllers;

use App\Http\Model\Nasabah_m;
use Illuminate\Http\Request;
use App\Http\Model\Simpan_tabungan_m;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Tarik_tabungan_m;
use App\Http\Model\User_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;
use Helpers;

class HalamanNasabahController extends Controller
{
    public function __construct()
    {
        $this->nameroutes = 'riwayat-transaksi-nasabah';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
        $nasabah = Nasabah_m::where('user_id', Helpers::getId())->first();
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Riwayat Transaksi',
            'header'            => 'Data Riwayat Transaksi',
            'urlDatatables'     => 'riwayat-transaksi-nasabah/datatables',
            'idDatatables'      => 'dt_transaksi_nasabah',
            'get_saldo'         => Tabungan_m::where('nasabah_id', $nasabah->id)->first()->saldo
        );
        return view('halaman_nasabah.riwayat_transaksi',$data);
    }

    public function datatables_collection(Request $request)
    {
        $nasabah = Nasabah_m::where('user_id', Helpers::getId())->first();
        $params = $request->all();
        $simpanan = Simpan_tabungan_m::join('m_user','m_user.id','t_simpan_tabungan.user_id')
                     ->join('m_tabungan','m_tabungan.id','t_simpan_tabungan.tabungan_id')
                     ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                     ->where('m_tabungan.nasabah_id',$nasabah->id)
                     ->select(
                        't_simpan_tabungan.tanggal',
                         'm_nasabah.id_nasabah',
                         'm_nasabah.nama_nasabah',
                         'm_tabungan.no_rekening',
                         't_simpan_tabungan.nominal_setoran',
                         't_simpan_tabungan.saldo_akhir',
                         'm_user.nama as kolektor'
                     );
        if(!empty($params['tanggal'])){
            $simpanan->where('t_simpan_tabungan.tanggal', $params['tanggal']);
        }
        $penarikan = Tarik_tabungan_m::join('m_user','m_user.id','t_tarik_tabungan.user_id')
                    ->join('m_tabungan','m_tabungan.id','t_tarik_tabungan.tabungan_id')
                    ->join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
                    ->where('m_tabungan.nasabah_id',$nasabah->id)
                    ->select(
                        't_tarik_tabungan.tanggal',
                        'm_nasabah.id_nasabah',
                        'm_nasabah.nama_nasabah',
                        'm_tabungan.no_rekening',
                        't_tarik_tabungan.nominal_penarikan',
                        't_tarik_tabungan.saldo_akhir',
                        'm_user.nama as kolektor'
                    );
        if(!empty($params['tanggal'])){
            $penarikan->where('t_tarik_tabungan.tanggal', $params['tanggal']);
        }
        $result = collect(array_merge($simpanan->get()->toArray(), $penarikan->get()->toArray()))->sortby('tanggal');


        return Datatables::of($result )->make(true);
    }

    public function resetPassword(Request $request)
    {
        $user = User_m::where('id', Helpers::getId())->first();
        $data = array(
            'title'             => 'Reset Password',
            'header'            => 'Halaman Ini Digunakan Untuk Reset Password',
            'submit_url'            => url()->current(),
        );

         //jika form sumbit
         if($request->post())
         {
             $header = $request->input('f');
             $validator = Validator::make( $header, [
                'password_lama' => 'required',
                'password_baru' => 'required|string|min:6|same:konfirmasi_password_baru',
                'konfirmasi_password_baru' => 'required',
              ]);
             if ($validator->fails()) {
                 $response = [
                     'message' => $validator->errors()->first(),
                     'status' => 'error',
                     'code' => 500,
                 ];
                 return Response::json($response);
             }
            if (!\Hash::check($header['password_lama'], $user->password)) {
                $response = [
                    'message' => 'Password lama tidak sesuai!',
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

             DB::beginTransaction();
             try {
                $password = \Hash::make($header['password_baru']);
                User_m::where('id', $user->id)->update(['password' => $password]);
                DB::commit();
                 $response = [
                     "message" => 'Reset password berhasil.',
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
        return view('halaman_nasabah.pengaturan',$data);
    }


}
