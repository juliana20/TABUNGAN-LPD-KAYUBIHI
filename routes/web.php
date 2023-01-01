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
	Route::match(array('GET', 'POST'),'/reset-password/{id}','NasabahController@resetPassword');
	Route::match(array('GET', 'POST'),'/generate-bunga','NasabahController@generateBunga');
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
#TARIK TABUNGAN
Route::prefix('tarik-tabungan')->group(function() {
    Route::get('/', 'TarikTabunganController@index');
	Route::match(array('GET', 'POST'),'/datatables','TarikTabunganController@datatables_collection');
	Route::match(array('GET', 'POST'),'/edit/{id}','TarikTabunganController@edit');
});

#TRANSAKSI KOLEKTOR
Route::prefix('transaksi-kolektor')->group(function() {
    Route::get('/', 'TransaksiKolektorController@index');
	Route::match(array('GET', 'POST'),'/transaksi','TransaksiKolektorController@transaksi');
	Route::match(array('GET', 'POST'),'/proses-transaksi/{no_rekening}','TransaksiKolektorController@prosesTransaksi');
});

#HALAMAN NASABAH
Route::match(array('GET', 'POST'),'/reset-password', 'HalamanNasabahController@resetPassword');
Route::prefix('riwayat-transaksi-nasabah')->group(function() {
    Route::get('/', 'HalamanNasabahController@index');
	Route::match(array('GET', 'POST'),'/datatables','HalamanNasabahController@datatables_collection');
	// Route::match(array('GET', 'POST'),'/transaksi','TransaksiKolektorController@transaksi');
	// Route::match(array('GET', 'POST'),'/proses-transaksi/{no_rekening}','TransaksiKolektorController@prosesTransaksi');
});

#VALIDASI SETORAN
Route::prefix('validasi-setoran')->group(function() {
    Route::get('/', 'ValidasiSetoranController@index');
	Route::match(array('GET', 'POST'),'/datatables','ValidasiSetoranController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','ValidasiSetoranController@create');
	Route::match(array('GET', 'POST'),'/get-detail','ValidasiSetoranController@getDetail');
	Route::match(array('GET', 'POST'),'/delete/{id}','ValidasiSetoranController@delete');
});

#TUTUP BUKU
Route::prefix('tutup-buku')->group(function() {
    Route::get('/', 'TutupBukuController@index');
	Route::match(array('GET', 'POST'),'/datatables','TutupBukuController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','TutupBukuController@create');
	Route::match(array('GET', 'POST'),'/get-detail','TutupBukuController@getDetail');
	Route::match(array('GET', 'POST'),'/delete/{id}','TutupBukuController@delete');
});


#DASHBOARD
Route::prefix('dashboard')->group(function() {
	Route::get('/','Dashboard@index');
	Route::post('/chart-simpanan','Dashboard@chartSimpanan');
	Route::post('/chart-penarikan','Dashboard@chartPenarikan');
	Route::post('/chart-transaksi-harian','Dashboard@chartTransaksiHarian');
	Route::post('/chart-nasabah','Dashboard@chartNasabah');
	Route::post('/chart-nasabah-tabungan-terbanyak','Dashboard@chartNasabahTabunganTerbanyak');
});


#LAPORAN
Route::prefix('laporan')->group(function() {
	Route::get('/transaksi-tabungan-harian','Laporan@transaksiTabunganHarian');
	Route::match(array('GET', 'POST'),'transaksi-tabungan-harian/datatables','Laporan@transaksiTabunganHarianDatatables');
	Route::post('/transaksi-tabungan-harian/print','Laporan@printTransaksiTabunganHarian');

	Route::get('/transaksi-tabungan-bulanan','Laporan@transaksiTabunganBulanan');
	Route::match(array('GET', 'POST'),'transaksi-tabungan-bulanan/datatables','Laporan@transaksiTabunganBulananDatatables');
	Route::post('/transaksi-tabungan-bulanan/print','Laporan@printTransaksiTabunganBulanan');

	Route::get('/simpanan-tabungan','Laporan@simpananTabungan');
	Route::match(array('GET', 'POST'),'simpanan-tabungan/datatables','Laporan@simpananTabunganDatatables');
	Route::post('/simpanan-tabungan/print','Laporan@printSimpananTabungan');

	Route::get('/penarikan-tabungan','Laporan@penarikanTabungan');
	Route::match(array('GET', 'POST'),'penarikan-tabungan/datatables','Laporan@penarikanTabunganDatatables');
	Route::post('/penarikan-tabungan/print','Laporan@printPenarikanTabungan');

	Route::get('/cetak-buku-tabungan','Laporan@cetakBukuTabungan');
	Route::post('/cetak-buku-tabungan/print','Laporan@previewBukuTabungan');
	Route::post('/cetak-buku-tabungan/cetak','Laporan@printBukuTabungan');
	Route::match(array('GET', 'POST'),'/cetak-buku-tabungan/preview','Laporan@collectionPreviewBukuTabungan');

});

});

?>