<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Jurnal_umum_m extends Model
{
	protected $table = 't_jurnal_umum';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_jurnal';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'kode_jurnal' => "required|unique:{$this->table}",
				'tanggal' => 'required',
				'akun_id' => 'required',
            ],
			'update' => [
				'tanggal' => 'required',
				'tanggal' => 'required',
				'akun_id' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = self::join('m_user','t_jurnal_umum.user_id','=','m_user.id')
						->join('m_akun','t_jurnal_umum.akun_id','=','m_akun.id')
						->select('t_jurnal_umum.*','m_user.nama as nama_user','m_akun.kode_akun','m_akun.nama_akun');

        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = self::join('m_user','t_jurnal_umum.user_id','=','m_user.id')
				->join('m_akun','t_jurnal_umum.akun_id','=','m_akun.id')
				->where("t_jurnal_umum.{$this->index_key}", $id)
				->select('t_jurnal_umum.*','m_user.nama as nama_user','m_akun.kode_akun','m_akun.nama_akun');

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

}
