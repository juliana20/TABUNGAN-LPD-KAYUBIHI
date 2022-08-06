<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_m extends Model
{
	protected $table = 't_pengeluaran';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_pengeluaran';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'kode_pengeluaran' => "required|unique:{$this->table}",
				'tanggal' => 'required',
				'akun_id' => 'required',
				'total' => 'required'
            ],
			'update' => [
				'tanggal' => 'required',
				'akun_id' => 'required',
				'total' => 'required'
            ],
        ];
	}

    function get_all()
    {
		$query = self::join('m_akun','t_pengeluaran.akun_id','=','m_akun.id')
				->select('t_pengeluaran.*','m_akun.kode_akun','m_akun.nama_akun');

		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = self::join('m_akun','t_pengeluaran.akun_id','=','m_akun.id')
				->join('m_user','t_pengeluaran.user_id','=','m_user.id')
				->where("t_pengeluaran.{$this->index_key}", $id)
				->select('t_pengeluaran.*','m_akun.kode_akun','m_akun.nama_akun','m_user.nama as nama_user');

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

	function gen_code( $format )
	{
		$max_number = self::all()->max($this->index_key2);
		$noUrut = (int) substr($max_number, -4);
		$noUrut++;
		$date = date('Y-m-d');
		$month = date('m', strtotime($date));
		$year = date('y', strtotime($date));
		$day = date('d', strtotime($date));
		$code = $format;
		$no_generate = $code.'-'.$year.$month.$day.'-'.sprintf("%04s", $noUrut);

		return (string) $no_generate;
	}

}
