<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Akun_m extends Model
{
	protected $table = 'tb_akun';
	protected $index_key = 'id';
	protected $index_key2 = 'id_akun';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_akun' => 'required|unique:tb_akun',
				'nama_akun' => 'required',
            ],
			'update' => [
				'nama_akun' => 'required',
            ],
        ];
	}

    function get_all()
    {
        return self::get();
    }

	function get_all_lookup($params)
    {
		$query = DB::table("{$this->table}")
				->select('*');

		if(!empty($params['kelompok'])){
			$query->where('kelompok', $params['kelompok']);
		}
		if(!empty($params['golongan'])){
			$query->where('golongan', $params['golongan']);
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

}
