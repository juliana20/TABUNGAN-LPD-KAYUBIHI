<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tabungan_berjangka_m extends Model
{
	protected $table = 'tb_tabungan_berjangka';
	protected $index_key = 'id';
	protected $index_key2 = 'id_tabungan_berjangka';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_tabungan_berjangka' => 'required|unique:tb_tabungan_berjangka',
				'id_nasabah' => 'required',
            ],
			'update' => [
				'id_nasabah' => 'required',
            ],
        ];
	}

    function get_all($params)
    {

		$query = DB::table("{$this->table} as a")
				 ->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
				 ->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
				 ->select(
					 'a.id_tabungan_berjangka',
					 'a.id_user',
					 'a.id_nasabah',
					 'a.jangka_waktu',
					 'a.jangka_waktu_hari',
					 'a.jangka_waktu_bulan',
					 'a.tanggal_awal',
					 'a.jatuh_tempo',
					 'a.bunga_tabungan_berjangka',
					 'a.total_bunga',
					 'a.nominal_tabungan_berjangka',
					 'a.total_tabungan_berjangka',
					 'a.status_tabungan_berjangka',
					 'a.denda_pinalti',
					 'c.nama_nasabah',
					 DB::raw('SUM(b.kredit) AS saldo_berjalan')
				)->groupBy(
					'a.id_tabungan_berjangka',
					 'a.id_user',
					 'a.id_nasabah',
					 'a.jangka_waktu',
					 'a.jangka_waktu_hari',
					 'a.jangka_waktu_bulan',
					 'a.tanggal_awal',
					 'a.jatuh_tempo',
					 'a.bunga_tabungan_berjangka',
					 'a.total_bunga',
					 'a.nominal_tabungan_berjangka',
					 'a.total_tabungan_berjangka',
					 'a.status_tabungan_berjangka',
					 'a.denda_pinalti',
					 'c.nama_nasabah'
				);

		if(!empty($params['proses']) && $params['proses'] == 1){
			$query->where('a.status_tabungan_berjangka', '=', 1);
		}else{
			$query->where('a.status_tabungan_berjangka', '=', 0);
		}
		return $query->get();
    }

		
	function get_all_tabungan_berjangka($params)
    {
		$query = DB::table("{$this->table} as a")
				->join('tb_tabungan_berjangka_detail as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
				->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
				->select('b.*','c.nama_nasabah','a.id_nasabah');

		if(!empty($params['setoran']) && $params['setoran'] == 1){
			$query->where('b.kredit', '<>', 0);
		}
		if(!empty($params['penarikan']) && $params['penarikan'] == 1){
			$query->where('b.debet', '<>', 0);
		}
		if(!empty($params['proses']) && $params['proses'] == 1){
			$query->where('b.proses', '=', 1);
		}else{
			$query->where('b.proses', '=', 0);
		}
		if(!empty($params['date_start']) && !empty($params['date_end'])){
			$query->where('b.tanggal', '>=', date('Y-m-d', strtotime($params['date_start'])));
			$query->where('b.tanggal', '<=', date('Y-m-d', strtotime($params['date_end'])));
		}
		return $query->get();
    }

	
	function get_all_tabungan_nasabah($params)
    {
		$query = DB::table('tb_tabungan_berjangka as a')
				->join('tb_tabungan_berjangka_detail as b','b.id_tabungan_berjangka','=','a.id_tabungan_berjangka')
				->join('tb_nasabah as c','a.id_nasabah','=','c.id_nasabah')
				->select('b.*','c.nama_nasabah','a.nominal_tabungan_berjangka')
				->orderBy('b.tanggal');
;
		if(!empty($params['id_nasabah'])){
			$query->where('a.id_nasabah', '=', $params['id_nasabah']);
		}
		
		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function insert_data_detail($data)
	{
		return DB::table('tb_tabungan_berjangka_detail')->insert($data);
	}


	function get_one($id)
	{
		return self::where($this->index_key, $id)->first();
	}

	function get_by( $where )
	{
		$query = DB::table("{$this->table} as a")
				 ->join('tb_nasabah as b','a.id_nasabah','=','b.id_nasabah')
				 ->select('a.*','b.nama_nasabah')
				 ->where($where);

		return 	$query->first();
	}

	function get_by_in( $where, $data )
	{
		return self::whereIn($where, $data)->get();
	}

	function update_data($data, $id)
	{
		return self::where($this->index_key2, $id)->update($data);
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

	function gen_no_bukti_deposito( $format )
	{
		$max_number = DB::table($this->table)->get()->max($this->index_key2);
		$detik = date("his");
		$noUrut = (int) $detik;
		$noUrut++;
		$date = date('dm');
		$code = $format . $date;
		$no_generate = $code . sprintf("%03s", '0'.$detik);

		return (string) $no_generate;
	}

	function get_saldo( $id_tabungan_berjangka = null )
	{
		$query = DB::table($this->table)
				->where('id_tabungan_berjangka', $id_tabungan_berjangka)
				->sum('nominal_tabungan_berjangka');

		return $query;
	}

	function get_debet_tabungan_berjangka( $id )
	{
		$query = DB::table('tb_tabungan_berjangka_detail')
				->where('id_tabungan_berjangka', $id)
				// ->where('proses', 1)
				->sum('debet');

		return $query;
	}
	function get_kredit_tabungan_berjangka( $id )
	{
		$query = DB::table('tb_tabungan_berjangka_detail')
				->where('id_tabungan_berjangka', $id)
				// ->where('proses', 1)
				->sum('kredit');

		return $query;
	}

	function get_collection( $id )
	{
		$query = DB::table('tb_tabungan_berjangka_detail')
				->where('id_tabungan_berjangka', $id)
				// ->where('proses', 1)
				->select('*');

		return $query->get();
	}

}
