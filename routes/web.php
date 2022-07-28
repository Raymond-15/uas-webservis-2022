<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PromoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

Route::get('/barang/tambah', [BarangController::class, 'tambah'])->name('barang.tambah');
Route::post('barang/simpan', [BarangController::class, 'simpan'])->name('barang.simpan');
Route::get('/barang/ubah/{id}', [BarangController::class, 'ubah'])->name('barang.ubah');
Route::get('/barang/hapus/{id}', [BarangController::class, 'hapus'])->name('barang.hapus');
Route::post('barang/perbaharui', [BarangController::class, 'perbaharui'])->name('barang.perbaharui');

Route::get('/barang/show', [BarangController::class, 'show'])->name('barang.show');

Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
Route::get('/promo/tambah', [PromoController::class, 'tambah'])->name('promo.tambah');
Route::post('/promo/simpan', [PromoController::class, 'simpan'])->name('promo.simpan');
Route::get('/promo/hapus/{id}', [PromoController::class, 'hapus'])->name('promo.hapus');
Route::get('/promo/ubah/{id}', [PromoController::class, 'ubah'])->name('promo.ubah');
Route::post('/promo/perbaharui', [PromoController::class, 'perbaharui'])->name('promo.perbaharui');
