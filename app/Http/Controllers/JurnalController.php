<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Jurnal_umum_m;
use Validator;
use DataTables;
use Helpers;
use DB;
use Response;

class JurnalController extends Controller
{
    protected $model;
    public function __construct(Jurnal_umum_m $model)
    {
        $this->model = $model;
        $this->nameroutes = 'jurnal-umum';
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
            'title'             => 'Jurnal Umum',
            'header'            => 'Jurnal Umum',
            'breadcrumb'        => 'List Jurnal Umum',
            'urlDatatables'     => "{$this->nameroutes}/datatables",
            'idDatatables'      => 'dt_jurnal_umum'
        );
        return view('jurnal_umum.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_jurnal' => $this->model->gen_code('JUM'),
            'tanggal' => date('Y-m-d')
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Buat Transaksi Jurnal Umum',
            'breadcrumb'        => 'Daftar Transaksi Jurnal Umum',
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = array_merge($item, $request->input('header'));
            $header['id_jurnal'] = $this->model->gen_code('JUM');
            $header['id_user'] = Helpers::getId();
            $header['tanggal'] = date('Y-m-d h:i:s', strtotime($header['tanggal']));
            $details = $request->input('details');

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
                //insert header get id
                $this->model->insert_data($header);
                $data_details = [];
                foreach($details as $row)
                {
                    $row['id_jurnal'] = $header['id_jurnal'];
                    $data_details[] = $row;
                }
                // insert detail
                $this->model_detail->insert_data($data_details);
                DB::commit();
    
                $response = [
                    "message" => 'Data jurnal umum berhasil dibuat',
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

        return view('jurnal.form', $data);

    }

    public function lookup_akun( )
    {
        return view('jurnal.lookup.akun');
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
    public function detail(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'title'                     => 'Lihat Transaksi Jurnal Umum',
            'breadcrumb'                => 'Daftar Transaksi Jurnal Umum',
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
            'collection'                => $this->model_detail->collection($get_data->id_jurnal)
        ];

        //jika form sumbit
        if($request->post())
        {
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data(['status_batal' => 1], $id);
                DB::commit();

                $response = [
                    "message" => 'Data jurnal umum berhasil dibatalkan!',
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
        
        return view('jurnal.form', $data);
    }

    public function datatables_collection(Request $request)
    {
        $params = $request->all();
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

        return Datatables::of($collection)->make(true);
    }


}
