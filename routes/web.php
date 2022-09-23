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
#NASABAH
Route::prefix('nasabah')->group(function() {
    Route::get('/', 'NasabahController@index');
	Route::match(array('GET', 'POST'),'/datatables','NasabahController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','NasabahController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','NasabahController@edit');
});
#SIMPAN TABUNGAN
Route::prefix('simpan-tabungan')->group(function() {
    Route::get('/', 'SimpanTabunganController@index');
	Route::match(array('GET', 'POST'),'/datatables','SimpanTabunganController@datatables_collection');
	Route::match(array('GET', 'POST'),'/edit/{id}','SimpanTabunganController@edit');
});
#PEGAWAI
Route::prefix('pegawai')->group(function() {
    Route::get('/', 'PegawaiController@index');
	Route::match(array('GET', 'POST'),'/datatables','PegawaiController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PegawaiController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PegawaiController@edit');
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

	#direktur
	Route::get('/perubahan/{log_id}', 'TransaksiSampahController@lookupPerubahan');
	Route::get('/get-notif', 'TransaksiSampahController@getNotif');
	Route::get('/data-sebelumnya/{log_id}', 'TransaksiSampahController@lookupDataSebelumnya');
	Route::match(array('GET', 'POST'),'/validasi-perubahan/{log_id}', 'TransaksiSampahController@validasiPerubahan');
	Route::get('/semua-perubahan', 'TransaksiSampahController@semuaPerubahan');
	Route::match(array('GET', 'POST'),'/datatables_perubahan','TransaksiSampahController@datatables_collection_perubahan');
});
#TRANSAKSI PEMBAYARAN ONLINE
Route::prefix('transaksi-pembayaran-online')->group(function() {
    Route::get('/', 'TransaksiOnlineController@index');
	Route::match(array('GET', 'POST'),'/datatables','TransaksiOnlineController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TransaksiOnlineController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','TransaksiOnlineController@edit');
	Route::match(array('GET', 'POST'),'/show/{id}','TransaksiOnlineController@show');
	Route::match(array('GET'),'/cetak-nota/{id}','TransaksiOnlineController@cetak_nota');

	#direktur
	Route::get('/perubahan/{log_id}', 'TransaksiOnlineController@lookupPerubahan');
	Route::get('/get-notif', 'TransaksiOnlineController@getNotif');
	Route::get('/data-sebelumnya/{log_id}', 'TransaksiOnlineController@lookupDataSebelumnya');
	Route::match(array('GET', 'POST'),'/validasi-perubahan/{log_id}', 'TransaksiOnlineController@validasiPerubahan');
	Route::get('/semua-perubahan', 'TransaksiOnlineController@semuaPerubahan');
	Route::match(array('GET', 'POST'),'/datatables_perubahan','TransaksiOnlineController@datatables_collection_perubahan');
});
#TRANSAKSI SAMSAT KENDARAAN
Route::prefix('transaksi-samsat-kendaraan')->group(function() {
    Route::get('/', 'TransaksiSamsatController@index');
	Route::match(array('GET', 'POST'),'/datatables','TransaksiSamsatController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TransaksiSamsatController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','TransaksiSamsatController@edit');
	Route::match(array('GET', 'POST'),'/show/{id}','TransaksiSamsatController@show');
	Route::match(array('GET'),'/cetak-nota/{id}','TransaksiSamsatController@cetak_nota');

	#direktur
	Route::get('/perubahan/{log_id}', 'TransaksiSamsatController@lookupPerubahan');
	Route::get('/get-notif', 'TransaksiSamsatController@getNotif');
	Route::get('/data-sebelumnya/{log_id}', 'TransaksiSamsatController@lookupDataSebelumnya');
	Route::match(array('GET', 'POST'),'/validasi-perubahan/{log_id}', 'TransaksiSamsatController@validasiPerubahan');
	Route::get('/semua-perubahan', 'TransaksiSamsatController@semuaPerubahan');
	Route::match(array('GET', 'POST'),'/datatables_perubahan','TransaksiSamsatController@datatables_collection_perubahan');
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
	Route::post('/chart-pengeluaran','Dashboard@chartPengeluaran');
	Route::post('/chart-pemasukan','Dashboard@chartPemasukan');
});

#JURNAL UMUM
Route::prefix('jurnal-umum')->group(function() {
    Route::get('/', 'JurnalController@index');
	Route::match(array('GET', 'POST'),'/datatables','JurnalController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','JurnalController@create');
	Route::match(array('GET', 'POST'),'/detail/{id}','JurnalController@detail');

	Route::get('/transaksi', 'JurnalController@transaksi');
	Route::match(array('GET', 'POST'),'/transaksi/datatables','JurnalController@datatables_collection_transaksi');
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

	Route::get('/buku-besar','Laporan@bukuBesar');
	Route::post('/buku-besar/print','Laporan@printBukuBesar');

	Route::get('/neraca','Laporan@neraca');
	Route::post('/neraca/print','Laporan@printNeraca');

	Route::get('/laba-rugi','Laporan@labaRugi');
	Route::post('/laba-rugi/print','Laporan@printLabaRugi');

	Route::get('/arus-kas','Laporan@arusKas');
	Route::post('/arus-kas/print','Laporan@printArusKas');

	Route::get('/perubahan-modal','Laporan@perubahanModal');
	Route::post('/perubahan-modal/print','Laporan@printPerubahanModal');
});

});

?>