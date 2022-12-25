<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tutup_buku_m extends Model
{
	protected $table = 't_tutup_buku';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'tanggal' => 'required',
				'user_id' => 'required',
            ],
			'update' => [
				'tanggal' => 'required',
				'user_id' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = self::join('m_user','m_user.id','t_tutup_buku.user_id')
					->select(
						't_tutup_buku.*',
						'm_user.nama as nama_user',
						'm_user.jabatan'
					);
        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = self::join('m_user','m_user.id','t_tutup_buku.user_id')
					->select(
						't_tutup_buku.*',
						'm_user.nama as nama_user',
						'm_user.jabatan'
					)
					->where("t_tutup_buku.{$this->index_key}", $id);

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
		$query = self::where($where);
		return $query->update($data);
	}

}
