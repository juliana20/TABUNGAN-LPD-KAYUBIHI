<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Simpan_tabungan_m extends Model
{
	protected $table = 't_simpan_tabungan';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'nominal_setoran' => "required",
				'tanggal' => 'required',
				'user_id' => 'required',
				'tabungan_id' => 'required',
				'saldo_awal' => 'required',
				'saldo_akhir' => 'required',
            ],
			'update' => [
				'nominal_setoran' => "required",
				'tanggal' => 'required',
				'user_id' => 'required',
				'tabungan_id' => 'required',
				'saldo_awal' => 'required',
				'saldo_akhir' => 'required',
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
