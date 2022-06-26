<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tabungan_m extends Model
{
	protected $table = 'tb_tabungan_sukarela';
	protected $index_key = 'id';
	protected $index_key2 = 'id_tabungan_sukarela';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_tabungan_sukarela' => 'required|unique:tb_tabungan_sukarela',
				'id_nasabah' => 'required',
            ],
			'update' => [
				'id_nasabah' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = DB::table('tb_nasabah')->where('no_rek_tabungan','<>', '')->get();
			foreach($query as $row){
				$debet = self::get_debet_tabungan($row->id_nasabah);
				$kredit = self::get_kredit_tabungan($row->id_nasabah);
				$data[] = [
					'no_rek_tabungan' => $row->no_rek_tabungan,
					'id_nasabah' => $row->id_nasabah,
					'nama_nasabah' => $row->nama_nasabah,
					'saldo'	=> $kredit - $debet,
					'tanggal_daftar' => $row->tanggal_daftar
				];
			}
		
		return (!empty($data)) ? $data : $data[] = [];
    }
	
	function get_all_tabungan($params)
    {
		$query = DB::table('tb_tabungan_sukarela as a')
				->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
				->select('a.*','b.nama_nasabah');

		if(!empty($params['setoran']) && $params['setoran'] == 1){
			$query->where('a.kredit', '<>', 0);
		}
		if(!empty($params['penarikan']) && $params['penarikan'] == 1){
			$query->where('a.debet', '<>', 0);
		}
		if(!empty($params['proses']) && $params['proses'] == 1){
			$query->where('a.proses', '=', 1);
		}else{
			$query->where('a.proses', '=', 0);
		}
		if(!empty($params['date_start']) && !empty($params['date_end'])){
			$query->where('a.tanggal', '>=', date('Y-m-d', strtotime($params['date_start'])));
			$query->where('a.tanggal', '<=', date('Y-m-d', strtotime($params['date_end'])));
		}
		return $query->get();
    }

	function get_all_tabungan_nasabah($params)
    {
		$query = DB::table('tb_tabungan_sukarela as a')
				->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
				->select('a.*','b.nama_nasabah')
				->orderBy('a.tanggal');

		if(!empty($params['id_nasabah'])){
			$query->where('a.id_nasabah', '=', $params['id_nasabah']);
		}
		
		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}


	function get_one($id)
	{
		return self::where($this->index_key, $id)->first();
	}

	function get_by( $where )
	{
		$query = DB::table('tb_tabungan_sukarela as a')
				->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
				->join('tb_user as c','a.id_user','=','c.id')
				->select('a.*','b.nama_nasabah','b.tanggal_daftar','c.nama_user')
				->where($where);

		return 	$query->first();
	}

	function get_by_in( $where, $data )
	{
		return self::whereIn($where, $data)->get();
	}

	function update_data($data, $id)
	{
		return self::where($this->index_key, $id)->update($data);
	}

	function update_by($data, Array $where)
	{
		$query = DB::table($this->table)->where($where);
		return $query->update($data);
	}

	function gen_code( $format )
	{
		$max_number = self::all()->max($this->index_key2);
		$noUrut = (int) substr($max_number, 3, 3);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%03s", $noUrut);

		return (string) $no_generate;
	}

	function gen_no_bukti_tabungan( $format )
	{
		$max_number = DB::table('tb_tabungan_sukarela')->get()->max('id_tabungan_sukarela');
		$detik = date("his");
		$noUrut = (int) $detik;
		$noUrut++;
		$date = date('dm');
		$code = $format . $date;
		$no_generate = $code . sprintf("%03s", '0'.$detik);

		return (string) $no_generate;
	}

	function get_debet_tabungan( $id_nasabah )
	{
		$query = DB::table('tb_tabungan_sukarela')
				->where('id_nasabah', $id_nasabah)
				// ->where('proses', 1)
				->sum('debet');

		return $query;
	}
	function get_kredit_tabungan( $id_nasabah )
	{
		$query = DB::table('tb_tabungan_sukarela')
				->where('id_nasabah', $id_nasabah)
				// ->where('proses', 1)
				->sum('kredit');

		return $query;
	}
	function get_collection( $id_nasabah )
	{
		$query = DB::table('tb_tabungan_sukarela')
				->where('id_nasabah', $id_nasabah)
				// ->where('proses', 1)
				->select('*')
				->orderBy('tanggal','ASC');

		return $query->get();
	}

}
