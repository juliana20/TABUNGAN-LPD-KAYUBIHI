<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Transaksi_samsat_m extends Model
{
	protected $table = 't_samsat';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_transaksi_samsat';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'kode_transaksi_samsat' => "required|unique:{$this->table}",
				'pelanggan_id' => 'required',
				'plat_nomor' => 'required',
				'tanggal_samsat' => 'required',
				'jenis_kendaraan' => 'required',
				'jumlah_tagihan' => 'required'
            ],
			'update' => [
				'pelanggan_id' => 'required',
				'plat_nomor' => 'required',
				'tanggal_samsat' => 'required',
				'jenis_kendaraan' => 'required',
				'jumlah_tagihan' => 'required'
            ],
        ];
	}

    function get_all($params)
    {
		$query = self::join('m_pelanggan','t_samsat.pelanggan_id','=','m_pelanggan.id')
						->select('t_samsat.*','m_pelanggan.nama as nama_pelanggan');

		if(!empty($params['jenis_kendaraan'])){
			$query->where('jenis_kendaraan', $params['jenis_kendaraan']);
		}

		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		return self::join('m_pelanggan','t_samsat.pelanggan_id','=','m_pelanggan.id')
						->join('m_user','t_samsat.user_id','=','m_user.id')
						->where("t_samsat.{$this->index_key}", $id)
						->select('t_samsat.*','m_pelanggan.nama as nama_pelanggan','m_user.nama as nama_user')
						->first();
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
		$noUrut = (int) substr($max_number, 3, 3);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%03s", $noUrut);

		return (string) $no_generate;
	}

}
