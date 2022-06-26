<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tabungan_berjangka_detail_m extends Model
{
	protected $table = 'tb_tabungan_berjangka_detail';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{

	}

    function get_all()
    {
        return self::get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table("{$this->table} as a")
			     ->join('tb_tabungan_berjangka as b','a.id_tabungan_berjangka','=','b.id_tabungan_berjangka')
				 ->join('tb_nasabah as c','b.id_nasabah','=','c.id_nasabah')
				 ->join('tb_user as d','a.id_user','=','d.id')
				 ->select('a.*','c.nama_nasabah','c.tanggal_daftar','d.nama_user')
				 ->where("a.{$this->index_key}", $id);

		return 	$query->first();
	}

	function get_by( $where )
	{
		return self::where($where)->first();
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


}
