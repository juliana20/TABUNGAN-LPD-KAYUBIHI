<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// RUOTE DIPAKAI =============================================================================================================
Route::get('/',function(){
	return view('auth.login');
});

Route::get('/login','Login@login');
Route::post('/auth','Login@auth');
Route::get('/logout', 'Login@logout');

Route::group(['middleware' => ['admin']], function () {
#USER
Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
	Route::match(array('GET', 'POST'),'/datatables','UserController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','UserController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','UserController@edit');
});
#AKUN
Route::prefix('akun')->group(function() {
    Route::get('/', 'AkunController@index');
	Route::match(array('GET', 'POST'),'/datatables','AkunController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','AkunController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','AkunController@edit');
	Route::match(array('GET', 'POST'),'/lookup_collection','AkunController@lookup_collection');
});
#JENIS TRANSAKSI
Route::prefix('jenis-transaksi')->group(function() {
    Route::get('/', 'JenisTransaksiController@index');
	Route::match(array('GET', 'POST'),'/datatables','JenisTransaksiController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','JenisTransaksiController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','JenisTransaksiController@edit');
});
#PELANGGAN
Route::prefix('pelanggan')->group(function() {
    Route::get('/', 'PelangganController@index');
	Route::match(array('GET', 'POST'),'/datatables','PelangganController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PelangganController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PelangganController@edit');
});
#SETTING PARAMETER
Route::prefix('setting-parameter')->group(function() {
    Route::match(array('GET', 'POST'),'/', 'SettingParameterController@form');
});
#TRANSAKSI RETRIBUSI SAMPAH
Route::prefix('transaksi-retribusi-sampah')->group(function() {
    Route::get('/', 'TransaksiSampahController@index')->name('transaksi-retribusi-sampah');
	Route::match(array('GET', 'POST'),'/datatables','TransaksiSampahController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TransaksiSampahController@create')->name('transaksi-retribusi-sampah.create');
	Route::match(array('GET', 'POST'),'/edit/{id}','TransaksiSampahController@edit')->name('transaksi-retribusi-sampah.edit');;
	Route::match(array('GET', 'POST'),'/show/{id}','TransaksiSampahController@show')->name('transaksi-retribusi-sampah.show');;
	Route::match(array('GET'),'/cetak-nota/{id}','TransaksiSampahController@cetak_nota');
});
#TRANSAKSI PEMBAYARAN ONLINE
Route::prefix('transaksi-pembayaran-online')->group(function() {
    Route::get('/', 'TransaksiOnlineController@index');
	Route::match(array('GET', 'POST'),'/datatables','TransaksiOnlineController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TransaksiOnlineController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','TransaksiOnlineController@edit');
	Route::match(array('GET', 'POST'),'/show/{id}','TransaksiOnlineController@show');
	Route::match(array('GET'),'/cetak-nota/{id}','TransaksiOnlineController@cetak_nota');
});
#TRANSAKSI SAMSAT KENDARAAN
Route::prefix('transaksi-samsat-kendaraan')->group(function() {
    Route::get('/', 'TransaksiSamsatController@index');
	Route::match(array('GET', 'POST'),'/datatables','TransaksiSamsatController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TransaksiSamsatController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','TransaksiSamsatController@edit');
	Route::match(array('GET', 'POST'),'/show/{id}','TransaksiSamsatController@show');
	Route::match(array('GET'),'/cetak-nota/{id}','TransaksiSamsatController@cetak_nota');
});

#PENGELUARAN
Route::prefix('pengeluaran')->group(function() {
    Route::get('/', 'PengeluaranController@index');
	Route::match(array('GET', 'POST'),'/datatables','PengeluaranController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PengeluaranController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PengeluaranController@edit');
	Route::match(array('GET', 'POST'),'/show/{id}','PengeluaranController@show');
	Route::match(array('GET'),'/cetak-nota/{id}','PengeluaranController@cetak_nota');
	Route::match(array('GET', 'POST'),'/lookup_detail','PengeluaranController@lookup_detail');
});

#DASHBOARD
Route::prefix('dashboard')->group(function() {
	Route::get('/','Dashboard@index');
	Route::match(array('GET', 'POST'),'/refresh','Dashboard@refresh');
	Route::post('/chart','Dashboard@chart');
});

#JURNAL UMUM
Route::prefix('jurnal-umum')->group(function() {
    Route::get('/', 'JurnalController@index');
	Route::match(array('GET', 'POST'),'/datatables','JurnalController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','JurnalController@create');
	Route::match(array('GET', 'POST'),'/detail/{id}','JurnalController@detail');
	Route::match(array('GET', 'POST'),'/lookup_akun','JurnalController@lookup_akun');
});

#LAPORAN
Route::prefix('laporan')->group(function() {
	Route::get('/retribusi-sampah','Laporan@retribusiSampah');
	Route::post('/retribusi-sampah/print','Laporan@printRetribusiSampah');

	Route::get('/pembayaran-online','Laporan@pembayaranOnline');
	Route::post('/pembayaran-online/print','Laporan@printPembayaranOnline');

	Route::get('/samsat-kendaraan','Laporan@samsatKendaraan');
	Route::post('/samsat-kendaraan/print','Laporan@printSamsatKendaraan');

	Route::get('/jurnal-umum','Laporan@jurnalUmum');
	Route::post('/jurnal-umum/print','Laporan@printJurnalUmum');

	Route::get('/keuangan','Laporan@keuangan');
	Route::post('/keuangan/print-jurnal-umum','Laporan@print_jurnal_umum');
	Route::post('/keuangan/print-buku-besar','Laporan@print_buku_besar');
	Route::post('/keuangan/print-laba-rugi','Laporan@print_laba_rugi');
	Route::post('/keuangan/print-neraca','Laporan@print_neraca');
	Route::post('/keuangan/print-arus-kas','Laporan@print_arus_kas');
	Route::post('/keuangan/print-neraca-lajur','Laporan@print_neraca_lajur');
});

#NASABAH
Route::prefix('nasabah')->group(function() {
    Route::get('/tabungan', 'TabunganController@tabungan_nasabah');
	Route::match(array('GET', 'POST'),'/tabungan/datatables','TabunganController@datatables_collection_nasabah');

	Route::get('/tabungan-berjangka', 'TabunganBerjangkaController@tabungan_nasabah');
	Route::match(array('GET', 'POST'),'/tabungan-berjangka/datatables','TabunganBerjangkaController@datatables_collection_nasabah');

	Route::get('/simpanan-anggota', 'SimpananAnggotaController@tabungan_nasabah');
	Route::match(array('GET', 'POST'),'/simpanan-anggota/datatables','SimpananAnggotaController@datatables_collection_nasabah');
	Route::match(array('GET', 'POST'),'/simpanan-anggota-pokok/datatables','SimpananAnggotaController@datatables_collection_simpanan_pokok_nasabah');

	Route::get('/pinjaman', 'PinjamanController@pinjaman_nasabah');
	Route::match(array('GET', 'POST'),'/pinjaman/datatables','PinjamanController@datatables_collection_pinjaman_nasabah');
});

});

?>