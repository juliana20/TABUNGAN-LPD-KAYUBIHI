<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Akun_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class AkunController extends Controller
{
    protected $golongan = [
        ['id' => 'Aktiva', 'desc' => 'Aktiva','level' => 1],
        ['id' => 'Hutang', 'desc' => 'Hutang', 'level' => 2],
        ['id' => 'Modal', 'desc' => 'Modal', 'level' => 3],
        ['id' => 'Pendapatan', 'desc' => 'Pendapatan', 'level' => 4],
        ['id' => 'HPP', 'desc' => 'HPP', 'level' => 5],
        ['id' => 'Biaya', 'desc' => 'Biaya', 'level' => 6],
    ];

    protected $kelompok = [
        ['id' => 'Aktiva Lancar', 'desc' => 'Aktiva Lancar'],
        ['id' => 'Pendapatan Operasional', 'desc' => 'Pendapatan Operasional'],
        ['id' => 'Pendapatan Non Operasional', 'desc' => 'Pendapatan Non Operasional'],
        ['id' => 'Hutang Lancar', 'desc' => 'Hutang Lancar'],
        ['id' => 'Modal', 'desc' => 'Modal'],
        ['id' => 'Biaya Operasional', 'desc' => 'Biaya Operasional'],
        ['id' => 'Biaya Non Operasional', 'desc' => 'Biaya Non Operasional'],
        ['id' => 'Piutang', 'desc' => 'Piutang'],
        ['id' => 'Aktiva Tetap', 'desc' => 'Aktiva Tetap'],
        ['id' => 'Ekuitas', 'desc' => 'Ekuitas'],
    ];

    protected $normal_pos = [
        ['id' => 'Debit', 'desc' => 'Debit'],
        ['id' => 'Kredit', 'desc' => 'Kredit'],
    ];

    protected $model;
    public function __construct(Akun_m $model)
    {
        $this->model = $model;
        $this->nameroutes = 'akun';
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
                'title'             => 'Akun',
                'header'            => 'Data Akun',
                'breadcrumb'        => 'List Data Akun',
                'headerModalTambah' => 'TAMBAH DATA AKUN',
                'headerModalEdit'   => 'UBAH DATA AKUN',
                'urlDatatables'     => 'akun/datatables',
                'idDatatables'      => 'dt_akun'
            );
            return view('akun.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'nama_akun' => null,
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_golongan'       => $this->golongan,
            'option_kelompok'       => $this->kelompok,
            'option_normal_pos'     => $this->normal_pos,
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
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
                    "message" => 'Data akun berhasil dibuat',
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

        return view('akun.form', $data);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'option_golongan'          => $this->golongan,
            'option_kelompok'       => $this->kelompok,
            'option_normal_pos'     => $this->normal_pos,
            'nameroutes'                => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header,[
                'kode_akun' => ['required', Rule::unique('m_akun')->ignore($get_data->kode_akun, 'kode_akun')],
                'nama_akun' => ['required'],
           ]);
           if ($validator->fails()) {
               $response = [
                   'message' => $validator->errors()->first(),
                   'status' => 'error',
                   'code' => 500,
               ];
               return Response::json($response);
           }
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data($header, $id);
                DB::commit();

                $response = [
                    "message" => 'Data akun berhasil diperbarui',
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
        
        return view('akun.form', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function lookup_collection()
    {
        $params = request()->all();
        $data = $this->model->get_all_lookup($params);
        return Datatables::of($data)->make(true);
    }


}
