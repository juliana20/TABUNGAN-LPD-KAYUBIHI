<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Simpan_tabungan_m extends Model
{
	protected $table = 'm_tabungan';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'no_rekening' => "required|unique:{$this->table}",
				'nasabah_id' => 'required',
				'tanggal_daftar' => 'required',
            ],
			'update' => [
				'nasabah_id' => 'required',
				'tanggal_daftar' => 'required',
            ],
        ];
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
		return self::first();
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
