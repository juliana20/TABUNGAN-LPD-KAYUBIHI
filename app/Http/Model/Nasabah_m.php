<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Nasabah_m extends Model
{
	protected $table = 'tb_nasabah';
	protected $index_key = 'id';
	protected $index_key2 = 'id_nasabah';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_nasabah' => 'required|unique:tb_nasabah',
				'no_rek_sim_pokok' => 'unique:tb_nasabah',
				'no_rek_sim_wajib' => 'unique:tb_nasabah',
				'no_rek_tabungan' => 'unique:tb_nasabah',
				'nama_nasabah' => 'required',
            ],
			'update' => [
				'nama_nasabah' => 'required',
            ],
        ];
	}

    function get_all()
    {
        return self::get();
    }

	function get_all_no_tabungan()
	{
		// return self::where('no_rek_tabungan','=', '')->get();
		return self::get();
	}
    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_user as b','a.id_user','=','b.id')
				->where("a.{$this->index_key}", $id)
				->select('a.*','b.username','b.password');
				
		return $query->first();
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

	function gen_code( $format )
	{
		$max_number = self::all()->max($this->index_key2);
		$noUrut = (int) substr($max_number, 3, 3);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%03s", $noUrut);

		return (string) $no_generate;
	}

	function gen_code_anggota( $format )
	{
		$max_number = self::all()->max('no_anggota');
		$noUrut = (int) substr($max_number, 3, 3);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%03s", $noUrut);

		return (string) $no_generate;
	}

	function gen_code_no_rek_wajib( $format )
	{	
		$max_number = self::all()->max('no_rek_sim_pokok');
		$noUrut = (int) substr($max_number, 8, 4);
		$noUrut++;
		$date = date('Y-m-d');
		$month = date('m', strtotime($date));
		$year = date('y', strtotime($date));
		$day = date('d', strtotime($date));
		$code = $format;
		$no_generate = $code.$year.$month.$day.sprintf("%04s", $noUrut);
		
		return (string) $no_generate;
	}
	function gen_code_no_rek_pokok( $format )
	{
		$max_number = self::all()->max('no_rek_sim_pokok');
		$noUrut = (int) substr($max_number, 8, 4);
		$noUrut++;
		$date = date('Y-m-d');
		$month = date('m', strtotime($date));
		$year = date('y', strtotime($date));
		$day = date('d', strtotime($date));
		$code = $format;
		$no_generate = $code.$year.$month.$day.sprintf("%04s", $noUrut);
		
		return (string) $no_generate;
	}
	function gen_code_no_rek_tabungan( $format )
	{
		$max_number = self::all()->max('no_rek_tabungan');
		$noUrut = (int) substr($max_number, 8, 4);
		$noUrut++;
		$date = date('Y-m-d');
		$month = date('m', strtotime($date));
		$year = date('y', strtotime($date));
		$day = date('d', strtotime($date));
		$code = $format;
		$no_generate = $code.$year.$month.$day.sprintf("%04s", $noUrut);
		
		return (string) $no_generate;
	}

}
