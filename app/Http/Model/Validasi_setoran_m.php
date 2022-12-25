<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Validasi_setoran_m extends Model
{
	protected $table = 't_validasi_setoran';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'tanggal' => "required",
				'kolektor_id' => 'required',
				'user_id' => 'required',
				'total' => 'required',
            ],
			'update' => [
				'tanggal' => "required",
				'kolektor_id' => 'required',
				'user_id' => 'required',
				'total' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = self::join('m_pegawai','m_pegawai.id','t_validasi_setoran.kolektor_id')
					->join('m_user','m_user.id','t_validasi_setoran.user_id')
					->select(
						't_validasi_setoran.*',
						'm_pegawai.nama_pegawai',
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
		$query = self::join('m_pegawai','m_pegawai.id','t_validasi_setoran.kolektor_id')
					->join('m_user','m_user.id','t_validasi_setoran.user_id')
					->select(
						't_validasi_setoran.*',
						'm_pegawai.nama_pegawai',
						'm_user.nama as nama_user',
						'm_user.jabatan'
					)
					->where("t_validasi_setoran.{$this->index_key}", $id);

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
