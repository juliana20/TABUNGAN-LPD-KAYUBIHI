<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Tabungan_m;
use App\Http\Model\Akun_m;
use App\Http\Model\Nasabah_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use Helpers;
use DB;
use Response;
use PDF;

class TabunganController extends Controller
{
    public function __construct()
    {
        $this->model = New Tabungan_m;
        $this->model_akun = New Akun_m;
        $this->model_nasabah = New Nasabah_m;
        $this->nameroutes = 'tabungan';
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
            'title'             => 'Data Tabungan Sukarela',
            'breadcrumb'        => 'List Data Tabungan Sukarela',
            'headerModalTambah' => 'TAMBAH DATA TABUNGAN SUKARELA',
            'headerModalEdit'   => 'UBAH DATA TABUNGAN SUKARELA',
            'urlDatatables'     => $this->nameroutes.'/datatables',
            'idDatatables'      => 'dt_tabungan'
        );
        return view('tabungan.datatable',$data);
    }

    public function list_setoran()
    {
         $data = array(
             'nameroutes'        => $this->nameroutes,
             'title'             => 'Data Setoran dan Penarikan Tabungan Sukarela',
             'breadcrumb'        => 'List Data Setoran dan Penarikan Tabungan Sukarela',
         );
         return view('tabungan.datatable.setoran',$data);
     }
     public function list_penarikan()
     {
          $data = array(
              'nameroutes'        => $this->nameroutes,
              'title'             => 'Data Penarikan Tabungan Sukarela',
              'breadcrumb'        => 'List Data Penarikan Tabungan Sukarela',
          );
          return view('tabungan.datatable.penarikan',$data);
      }

    public function create(Request $request)
    {
        $item = [
            'no_rek_tabungan' => $this->model_nasabah->gen_code_no_rek_tabungan('TB')
        ];
        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_akun'           => $this->model_akun->get_all(),
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $nasabah = $request->input('f');
            $nasabah['no_rek_tabungan'] = $this->model_nasabah->gen_code_no_rek_tabungan('TB');
            $id = $request->input('id');
            $tabungan = $request->input('t');
            $tabungan['tanggal'] = date('Y-m-d');
            $tabungan['id_user'] = Helpers::getId();
            $tabungan['id_nasabah'] = $id['id_nasabah'];
            $tabungan['saldo'] = str_replace(",", "", $tabungan['kredit']);
            $tabungan['kredit'] = str_replace(",", "", $tabungan['kredit']);
            $tabungan['id_tabungan_sukarela'] = $this->model->gen_no_bukti_tabungan('TTB');
            $tabungan['no_rek_tabungan'] = $nasabah['no_rek_tabungan'];

            DB::beginTransaction();
            try {
                $this->model_nasabah->update_by($nasabah, ['id_nasabah' => $id['id_nasabah']]);
                $this->model->insert_data($tabungan);
                DB::commit();
    
                $response = [
                    "message" => 'Tabungan sukarela berhasil dibuat',
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

        return view('tabungan.form', $data);

    }

    public function lookup_form_setoran(Request $request, $id)
    {
        $get_data = $this->model_nasabah->get_by(['id_nasabah' => $id]);

        $data = [
            'title'         => 'Setoran Tabungan Sukarela',
            'item'          => $get_data,
            'no_bukti'      => $this->model->gen_no_bukti_tabungan('TTB'),
            'submit_url'    => $this->nameroutes.'/simpan-tabungan',
            'is_edit'       => FALSE,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_nasabah),
            'option_akun'   => $this->model_akun->get_all()    
        ];

        return view('tabungan.lookup.setoran', $data);
    }

    public function lookup_form_penarikan(Request $request, $id)
    {
        $get_data = $this->model_nasabah->get_by(['id_nasabah' => $id]);

        $data = [
            'title'         => 'Penarikan Tabungan Sukarela',
            'item'          => $get_data,
            'no_bukti'      => $this->model->gen_no_bukti_tabungan('TTB'),
            'submit_url'    => $this->nameroutes.'/simpan-tabungan',
            'is_edit'       => FALSE,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_nasabah),
            'option_akun'   => $this->model_akun->get_all()    
        ];

        return view('tabungan.lookup.penarikan', $data);
    }

    
    public function simpan_tabungan(Request $request)
    {
            //jika form sumbit
            if($request->post())
            {
                $header = $request->input('f');
                $header['id_user'] = Helpers::getId();
                $header['id_tabungan_sukarela'] = $this->model->gen_no_bukti_tabungan('TTB');
    
                $validator = Validator::make( $header, $this->model->rules['insert']);
                if ($validator->fails()) {
                    $response = [
                        'message' => $validator->errors()->first(),
                        'status' => 'error',
                        'code' => 500,
                    ];
                    return Response::json($response);
                }
    
                DB::beginTransaction();
                try {
                    $this->model->insert_data($header);
                    DB::commit();
        
                    $response = [
                        "message" => 'Tabungan sukarela berhasil dibuat',
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
        $debet  = $this->model->get_debet_tabungan($id);
        $kredit = $this->model->get_kredit_tabungan($id);
        $saldo  = $kredit - $debet;

        return $saldo;
    }

    public function proses_setoran(Request $request, $id)
    {
        $get_data = $this->model->get_by(['a.id_nasabah' => $id]);

        $data = [
            'title'         => 'Detail Tabungan Sukarela',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($id),
            'collection'    => $this->model->get_collection($id),
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
                $this->model->update_by(['proses' => 1],['id_tabungan_sukarela' => $id]);
                DB::commit();

                $response = [
                    "message" => 'Setoran tabungan sukarela berhasil di proses',
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
        
        return view('tabungan.form.proses_setoran', $data);
    }

    
    public function proses_penarikan(Request $request, $id)
    {
        $get_data = $this->model->get_by(['id_tabungan_sukarela' => $id]);

        $data = [
            'title'         => 'Proses Penarikan Tabungan Sukarela',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'saldo'         => self::get_saldo($get_data->id_nasabah),
            'collection'    => $this->model->get_collection($get_data->id_nasabah),
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
                $this->model->update_by(['proses' => 1],['id_tabungan_sukarela' => $id]);
                DB::commit();

                $response = [
                    "message" => 'Penarikan tabungan sukarela berhasil di proses',
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
        
        return view('tabungan.form.proses_penarikan', $data);
    }

    public function cetak_tabungan($id)
    {
        $get_data = $this->model->get_by(['id_tabungan_sukarela' => $id]);
        $data = [
            'label' => ($get_data->debet == 0 || $get_data->debet == '') ? 'Jumlah Setor' : 'Jumlah Penarikan',
            // 'saldo' => self::get_saldo($get_data->id_nasabah),
            'saldo' =>  $get_data->saldo,
            'item'  => $get_data,
            'title' => ($get_data->debet == 0 || $get_data->debet == '') ? 'Bukti Setoran Tabungan Sukarela' : 'Bukti Penarikan Tabungan Sukarela',
        ];

        // return view('laporan.print.kategori_keuangan', $data);
        $pdf = PDF::loadView('tabungan.print.cetak_bukti_tabungan', $data)->setPaper('a5', 'portait');
        return $pdf->stream(($get_data->debet == 0 || $get_data->debet == '') ? 'Bukti Setoran Tabungan Sukarela' : 'Bukti Penarikan Tabungan Sukarela'.'.pdf'); 
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    
    public function datatables_collection_tabungan()
    {
        $params = request()->all();
        $data = $this->model->get_all_tabungan($params);
        return Datatables::of($data)->make(true);
    }

    public function tabungan_nasabah()
    {
         $data = array(
             'nameroutes'        => $this->nameroutes,
             'title'             => 'Data Tabungan Nasabah',
             'breadcrumb'        => 'List Data Tabungan Sukarela',
             'urlDatatables'     => 'nasabah/tabungan/datatables',
         );
         return view('tabungan.nasabah.datatable',$data);
     }

     public function datatables_collection_nasabah()
     {
         $params = request()->all();
         $data = $this->model->get_all_tabungan_nasabah($params);
         return Datatables::of($data)->make(true);
     }
 


}
