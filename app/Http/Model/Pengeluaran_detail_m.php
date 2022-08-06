<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_detail_m extends Model
{
	protected $table = 't_pengeluaran_detail';
	protected $index_key = 'id';
	protected $index_key2 = 'pengeluaran_id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'pengeluaran_id' => "required",
				'akun_id' => 'required',
            ],
			'update' => [
				'pengeluaran_id' => "required",
				'akun_id' => 'required',
            ],
        ];
	}

    function get_all()
    {
        $query = self::join('m_akun','t_pengeluaran_detail.akun_id','=','m_akun.id')
				->select('t_pengeluaran_detail.*','m_akun.kode_akun','m_akun.nama_akun');

		return $query->get();
    }

	function collection($id)
	{
		$query = self::join('m_akun','t_pengeluaran_detail.akun_id','=','m_akun.id')
				->where("t_pengeluaran_detail.{$this->index_key2}", $id)
				->select('t_pengeluaran_detail.*','m_akun.kode_akun','m_akun.nama_akun');
				
		return $query->get();
	}

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		return self::join('m_akun','t_pengeluaran_detail.akun_id','=','m_akun.id')
				->where("t_pengeluaran_detail.{$this->index_key}", $id)
				->select('t_pengeluaran_detail.*','m_akun.kode_akun','m_akun.nama_akun')->first();
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
