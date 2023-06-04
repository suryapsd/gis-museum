<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::get('/clear-cache', function() {
    $exitCode1 = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('config:clear');
    $exitCode3 = Artisan::call('view:clear');
    $exitCode4 = Artisan::call('route:clear');
    // $exitCode2 = Artisan::call('vendor:publish');
    // return what you want
    return "Clear Success";
});

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('actionlogin', [AdminController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [AdminController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');



Route::group(['middleware' => 'auth'], function(){
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index']);

    Route::resource('/admin/jenis-museum', App\Http\Controllers\JenisMuseumController::class);
    Route::post('museum/ajaxJenis-museum', [App\Http\Controllers\JenisMuseumController::class, 'getData']);

    Route::resource('/admin/museum', App\Http\Controllers\MuseumController::class);
    Route::post('museum/ajaxMuseums', [App\Http\Controllers\MuseumController::class, 'getData']);

    Route::resource('/admin/museum/{museum_id}/museum-images', App\Http\Controllers\ImagesController::class);
    Route::post('museum/ajaxMuseum-images', [App\Http\Controllers\ImagesController::class, 'getData']);

    Route::resource('/admin/museum/{museum_id}/pengurus', App\Http\Controllers\PengurusController::class);
    Route::post('museum/ajaxPengurus/{id}', [App\Http\Controllers\PengurusController::class, 'getData']);

    Route::resource('/admin/museum/{museum_id}/galeri', App\Http\Controllers\GaleriController::class);
    Route::post('museum/ajaxGaleri/{id}', [App\Http\Controllers\GaleriController::class, 'getData']);

    Route::resource('/admin/galeri/{galeri_id}/koleksi', App\Http\Controllers\KoleksiController::class);
    Route::post('museum/ajaxKoleksi/{id}', [App\Http\Controllers\KoleksiController::class, 'getData']);

    Route::resource('/admin/koleksi/{koleksi_id}/koleksi-images', App\Http\Controllers\KoleksiImageController::class);
    Route::post('museum/ajaxKoleksi-images', [App\Http\Controllers\KoleksiImageController::class, 'getData']);
});

Route::get('/', [App\Http\Controllers\MapController::class, 'index'])->name('home');
Route::get('/detail-museum/{id}', [App\Http\Controllers\MapController::class, 'show']);

Route::get('/detailmuseum', function () {
    return view('user.detail');
});