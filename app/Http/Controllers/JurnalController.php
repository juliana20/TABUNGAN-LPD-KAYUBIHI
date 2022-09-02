<?php

namespace App\Http\Controllers;

use App\Http\Model\Jurnal_m;
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
    protected $model_header_jurnal;
    public function __construct(Jurnal_umum_m $model, Jurnal_m $model_header_jurnal)
    {
        $this->model = $model;
        $this->model_header_jurnal = $model_header_jurnal;
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

    public function transaksi()
    {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Transaksi Jurnal Umum',
            'header'            => 'Data Transaksi Jurnal Umum',
            'urlDatatables'     => "{$this->nameroutes}/transaksi/datatables",
            'idDatatables'      => 'dt_transaksi_jurnal_umum'
        );
        return view('jurnal_umum.datatable_transaksi_jurnal',$data);
    }

     
    public function create(Request $request)
    {
        $item = [
            'kode_jurnal' => $this->model_header_jurnal->gen_code('JUM'),
            'tanggal' => date('Y-m-d')
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Buat Transaksi Jurnal Umum',
            'header'            => 'Form Transaksi Jurnal Umum',
            'breadcrumb'        => 'Daftar Transaksi Jurnal Umum',
            'submit_url'        => url()->current(),
            'is_edit'           => FALSE,
            'nameroutes'        => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = array_merge($item, $request->input('header'));
            $header['kode_jurnal'] = $this->model_header_jurnal->gen_code('JUM');
            $header['user_id'] = Helpers::getId();
            $details = $request->input('details');

            $validator = Validator::make( $header, $this->model_header_jurnal->rules['insert']);
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
                //insert data
                //insert header get id
                $this->model_header_jurnal->insert_data($header);
                $data_details = [];
                foreach($details as $row)
                {
                    $row['kode_jurnal'] = $header['kode_jurnal'];
                    $row['user_id'] = Helpers::getId();
                    $row['tanggal'] = $header['tanggal'];
                    $row['keterangan'] = !empty($row['keterangan']) ? $row['keterangan'] : $header['keterangan'];
                    $row['transaksi_jurnal'] = 1;
                    $data_details[] = $row;
                }
                // insert detail
                $this->model->insert_data($data_details);
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

        return view('jurnal_umum.form', $data);

    }

    public function lookup_akun( )
    {
        return view('jurnal_umum.lookup.akun');
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
        $get_data = $this->model_header_jurnal->get_one($id);
        $data = [
            'item'                      => $get_data,
            'title'                     => 'Lihat Transaksi Jurnal Umum',
            'header'                    => 'Form Transaksi Jurnal Umum',
            'breadcrumb'                => 'Daftar Transaksi Jurnal Umum',
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
            'collection'                => $this->model->collection($get_data->kode_jurnal)
        ];

        //jika form sumbit
        if($request->post())
        {
            //insert data
            DB::beginTransaction();
            try {
                $this->model_header_jurnal->update_data(['status_batal' => 1], $id);
                $this->model->where('kode_jurnal', $get_data->kode_jurnal)->update(['status_batal' => 1]);
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
        
        return view('jurnal_umum.form', $data);
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

        return Datatables::of($collection)->make(true);
    }

    public function datatables_collection_transaksi(Request $request)
    {
        $params = $request->all();
        $collection = $this->model_header_jurnal->get_all($params);

        return Datatables::of($collection)->make(true);
    }


}
