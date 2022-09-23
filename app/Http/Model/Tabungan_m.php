<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tabungan_m extends Model
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
		$query = self::join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
					->select(
						'm_nasabah.id_nasabah',
						'm_nasabah.nama_nasabah',
						'm_nasabah.alamat',
						'm_nasabah.jenis_kelamin',
						'm_nasabah.telepon',
						'm_nasabah.pekerjaan',
						'm_nasabah.tanggal_lahir',
						'm_nasabah.no_ktp',
						'm_nasabah.user_id',
						'm_nasabah.user_id',
						'm_nasabah.tanggal_daftar',
						'm_tabungan.id',
						'm_tabungan.no_rekening',
						'm_tabungan.saldo'
					);
        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = self::join('m_nasabah','m_nasabah.id','m_tabungan.nasabah_id')
					->where('m_tabungan.id', $id)
					->select(
						'm_nasabah.id_nasabah',
						'm_nasabah.nama_nasabah',
						'm_nasabah.alamat',
						'm_nasabah.jenis_kelamin',
						'm_nasabah.telepon',
						'm_nasabah.pekerjaan',
						'm_nasabah.tanggal_lahir',
						'm_nasabah.no_ktp',
						'm_nasabah.user_id',
						'm_nasabah.user_id',
						'm_nasabah.tanggal_daftar',
						'm_tabungan.id',
						'm_tabungan.no_rekening',
						'm_tabungan.saldo as saldo_awal'
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

	function gen_no_rek_tabungan( $format )
	{	
		$max_number = self::all()->max('no_rekening');
		$noUrut = (int) substr($max_number, 8, 5);

		$noUrut++;
		$date = date('Y-m-d');
		$month = date('m', strtotime($date));
		$year = date('Y', strtotime($date));
		$day = date('d', strtotime($date));
		$code = $format;
		$no_generate = $code.$day.$month.$year.sprintf("%05s", $noUrut);
		
		return (string) $no_generate;
	}

}
