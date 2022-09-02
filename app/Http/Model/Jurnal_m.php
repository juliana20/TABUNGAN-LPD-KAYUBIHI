<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Jurnal_m extends Model
{
	protected $table = 't_jurnal';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_jurnal';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'kode_jurnal' => "required|unique:{$this->table}",
				'tanggal' => 'required'
            ],
			'update' => [
				'tanggal' => 'required',
            ],
        ];
	}

    function get_all($params = [])
    {
		$query = self::join('m_user','t_jurnal.user_id','=','m_user.id')
						->select('t_jurnal.*','m_user.nama as nama_user');

		if(!empty($params))
		{
			$query->whereBetween('t_jurnal.tanggal',[$params['date_start'], $params['date_end']]);
		}
						
        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = self::join('m_user','t_jurnal.user_id','=','m_user.id')
				->where("t_jurnal.{$this->index_key}", $id)
				->select('t_jurnal.*','m_user.nama as nama_user');

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
