<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EntriPadamController;
use App\Http\Controllers\InputPelangganAPPController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UpdatingController;
use App\Http\Controllers\UserController;
use App\Models\MitraModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
//? Route untuk Auth
Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::get('/register_user', 'register_user');
    Route::get('/register_app_simaster', 'register_app_simaster');
    Route::get('/edit_user_simaster/{id}', 'edit_user_simaster');
    Route::post('/proses_edit_user_simaster/{id}', 'proses_edit_user_simaster');
    Route::post('/store', 'store');
    Route::post('/proseslogin', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->name('authenticate');
    Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');
});
Route::controller(InputPelangganAPPController::class)->group(function () {
    Route::get('/user', 'user')->middleware('auth')->name('user');
    Route::get('/entridata_user', 'entridata_user')->middleware('auth')->name('entridata_user');
    Route::get('/manajemen_aset_jaringan', 'manajemen_aset_jaringan')->middleware('auth')->name('manajemen_aset_jaringan');
    Route::get('/koordinator', 'koordinator')->middleware('auth')->name('koordinator');
    Route::get('/updating_koordinator', 'updating_koordinator')->middleware('auth')->name('updating_koordinator');
    Route::get('/pelanggan_demak', 'pelanggan_demak')->middleware('auth')->name('pelanggan_demak');
    Route::get('/pelanggan_tegowanu', 'pelanggan_tegowanu')->middleware('auth')->name('pelanggan_tegowanu');
    Route::get('/pelanggan_purwodadi', 'pelanggan_purwodadi')->middleware('auth')->name('pelanggan_purwodadi');
    Route::get('/pelanggan_wirosari', 'pelanggan_wirosari')->middleware('auth')->name('pelanggan_wirosari');
    Route::get('/koordinator/map_aset', 'map_aset')->middleware('auth')->name('map_aset');
    Route::get('/edit_pelanggan_app/{id}', 'edit_pelanggan_app')->middleware('auth')->name('edit_pelanggan_app');
    Route::get('/edit_pelanggan_app_user/{id_pelanggan}', 'edit_pelanggan_app_user')->middleware('auth')->name('edit_pelanggan_app_user');
    Route::post('/proses_edit_pelanggan_app/{id}', 'proses_edit_pelanggan_app');
    Route::post('/proses_edit_pelanggan_app_user/{id}', 'proses_edit_pelanggan_app_user');
    Route::post('/input_pelanggan_app', 'proses_input_pelangganapp');
    Route::post('/koordinator/import_excel_purwodadi', 'import_excel_purwodadi');
    Route::post('/koordinator/import_excel_wirosari', 'import_excel_wirosari');
    Route::post('/koordinator/import_excel_data_aset', 'import_excel_data_aset');
    Route::post('/koordinator/import_excel_data_gi', 'import_excel_data_gi');
    Route::post('/koordinator/import_excel_kelengkapan_data_aset', 'import_excel_kelengkapan_data_aset');
    Route::get('/export_excel_app', 'export_excel_app');
    Route::delete('/hapusPelangganAPP', 'hapusPelangganAPP');
    Route::get('/get-pelanggan/{nama_pelanggan}', 'getPelangganData');
});
Route::controller(UpdatingController::class)->group(function () {
    Route::get('/beranda', 'index')->middleware('auth')->name('beranda_administrator');
    Route::get('/entripadam', 'entri_padam')->middleware('auth');
    Route::delete('/hapus_pelanggan', 'hapusPelanggan');
    Route::get('/updating', 'updating')->middleware('auth');
    Route::get('/updating/editpelanggan/{id}', 'form_edit_pelanggan')->middleware('auth');
    Route::get('/updating/edittrafo/{id}', 'form_edit_trafo')->middleware('auth');
    Route::get('/updating/editwanotif/{id}', 'form_edit_wa_notif')->middleware('auth');
    Route::get('/updating/editdataunit/{id}', 'form_edit_data_unit')->middleware('auth');
    Route::get('/updating/editdatazone/{id}', 'form_edit_datazone')->middleware('auth');
    Route::get('/updating/editdatapohon/{id}', 'form_edit_datapohon')->middleware('auth');
    Route::get('/updating/export_excel_pelanggan', 'export_excel_pelanggan');
    Route::get('/updating/export_excel_trafo', 'export_excel_trafo');
    Route::post('/updating/import_excel', 'import_excel');
    Route::post('/updating/import_excel_trafo', 'import_excel_trafo');
    Route::post('/updating/import_excel_datazone', 'import_excel_datazone');
    Route::post('/updating/import_excel_datapohon', 'import_excel_datapohon');
    Route::post('/updating/import_excel_datatrafo', 'import_excel_datatrafo');
    Route::post('/updating/import_excel_penyulangsection', 'import_excel_penyulangsection');
    Route::delete('/updating/hapus_pelanggan', 'hapusPelanggan');
    Route::delete('/updating/hapus_trafo', 'hapusTrafo');
    Route::delete('/updating/hapus_dataunit', 'hapusDataUnit');
    Route::delete('/updating/hapus_wanotif', 'hapusWANotif');
    Route::delete('/updating/hapus_datazone', 'hapusDataZone');
    Route::delete('/updating/hapus_datapohon', 'hapusDataPohon');
    Route::post('/updating/proses_tambah_dataunit', 'proses_tambah_dataunit');
    Route::post('/updating/proses_tambah_wanotif', 'proses_tambah_wanotif');
    Route::post('/updating/edit_pelanggan/{id}', 'edit_pelanggan');
    Route::post('/updating/edit_trafo/{id}', 'edit_trafo');
    Route::post('/updating/edit_unit/{id}', 'edit_unit');
    Route::post('/updating/edit_wanotif/{id}', 'edit_wanotif');
    Route::post('/updating/edit_datazone/{id}', 'edit_datazone');
    Route::post('/updating/edit_datapohon/{id}', 'edit_datapohon');
});
Route::controller(EntriPadamController::class)->group(function () {
    Route::get('/petapadam', 'petapadam')->middleware('auth');
    Route::get('/petatrafo', 'peta_trafo')->middleware('auth');
    Route::get('/petazone', 'peta_zone')->middleware('auth');
    Route::get('/datapohon', 'datapohon')->middleware('auth');
    Route::get('/datatrafo', 'datatrafo')->middleware('auth');
    Route::get('/transaksihistori', 'index')->middleware('auth');
    Route::get('/transaksiaktif', 'transaksiaktif')->middleware('auth');
    Route::post('/entripadam/insertentripadam', 'insertEntriPadam');
    Route::post('/entripadam', 'insertPadam');
    Route::get('/transaksipadam/export_kali_padam', 'export_kali_padam');
    Route::get('/transaksiaktif/export_pelanggan_padam', 'export_pelanggan_padam');
    Route::get('/transaksiaktif/export_pelanggan_padam_csv', 'export_pelanggan_padam_csv');
    Route::get('/transaksipadam/hapus_entri', 'hapusEntriPadam');
    Route::post('/transaksipadam/edit_status_padam', 'editStatusPadam');
});
Route::controller(MitraController::class)->group(function () {
    Route::get('/keypoint', 'keypoint')->middleware('auth')->name('keypoint');
    Route::get('/rise_pole', 'rise_pole')->middleware('auth')->name('rise_pole');
    Route::get('/info_keypoint/{id}', 'info_keypoint');
    Route::post('/edit_keypoint/{id}', 'edit_keypoint');
    Route::delete('/delete_keypoint/{id}', 'delete_keypoint');
    Route::post('/import_excel_recloser_lbs', 'import_excel_recloser_lbs');
    Route::post('/import_excel_risepole', 'import_excel_risepole');
    Route::post('/keypoint/proses_tambah_keypoint', 'proses_tambah_keypoint');
});
