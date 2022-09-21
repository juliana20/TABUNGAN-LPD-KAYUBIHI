<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Nasabah_m extends Model
{
	protected $table = 'm_nasabah';
	protected $index_key = 'id';
	protected $index_key2 = 'id_nasabah';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_nasabah' => "required|unique:{$this->table}",
				'nama_nasabah' => 'required',
				'alamat' => 'required',
            ],
			'update' => [
				'nama_nasabah' => 'required',
				'alamat' => 'required',
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
		$query = self::join('m_user','m_user.id',"{$this->table}.user_id")
						->where("{$this->table}.id", $id)
						->select(
							"{$this->table}.*",
							'm_user.username',
							'm_user.password'
						);
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
		$noUrut = (int) substr($max_number, 2);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%05s", $noUrut);

		return (string) $no_generate;
	}


}
