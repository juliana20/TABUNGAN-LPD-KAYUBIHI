<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Bunga_tabungan_m extends Model
{
	protected $table = 't_bunga_tabungan';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'tabungan_id' => 'required',
				'periode_bunga' => 'required',
				'nominal_bunga' => 'required',
            ],
			'update' => [
				'tabungan_id' => 'required',
				'periode_bunga' => 'required',
				'nominal_bunga' => 'required',
            ],
        ];
	}

}
