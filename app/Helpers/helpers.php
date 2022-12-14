<?php
namespace App\Helpers;
use Session;
use App\Http\Model\Jabatan_m;
use App\Http\Model\Nasabah_m;
use App\Http\Model\Config_m;
use App\Http\Model\User_m;

class Helpers{

    public static function isLogin()
    {
        return (Session::get('login'));
    }

    public static function getId()
    {
        return (Session::get('id'));

    }

    public static function getIdNasabah()
    {
        $nasabah = Nasabah_m::where('user_id', Session::get('id'))->first();
        return $nasabah->id;

    }

    public static function getNama()
    {
        return (Session::get('nama'));
    }

    public static function getJabatan()
    {
        // $model_jabatan = New Jabatan_m;
        // $query = $model_jabatan->get_one(Session::get('jabatan'));
        // return $query->jabatan;
        return (Session::get('jabatan'));
    }

    public static function isNasabah()
    {
        $model = New Nasabah_m;
        $query = $model->get_by(['id_user' => Session::get('id')]);
        return $query->id_nasabah;
    }

    public static function getNasabah()
    {
        $model = New Nasabah_m;
        $query = $model->get_by(['id_user' => Session::get('id')]);
        return $query->nama_nasabah;
    }

    public static function isAdmin()
    {
        $model_user = New User_m;
        $query = $model_user->get_one(Session::get('id'));
        return ($query->jabatan == 'Admin');
    }
    public static function isKetuaYayasan()
    {
        $model_jabatan = New Jabatan_m;
        $query = $model_jabatan->get_one(Session::get('jabatan'));
        return ($query->jabatan == 'Ketua Yayasan');

    }

    public static function config_item( $params )
    {
        $model_config = New Config_m;
        $query = $model_config->get_one($params);
        return $query->value;
    }
}