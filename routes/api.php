<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('barang/getall', [BarangController::class, 'getAll']);
Route::get('barang/show', [BarangController::class, 'show']);
Route::post('barang/store', [BarangController::class, 'store'])->middleware('auth:api');
Route::post('barang/update', [BarangController::class, 'update']);
Route::post('barang/destroy', [BarangController::class, 'destroy'])->middleware('auth:api');

Route::get('promo/show', [PromoController::class, 'show']);
Route::get('promo/getall', [PromoController::class, 'getAll']);
Route::post('promo/destroy', [PromoController::class, 'destroy']);
Route::post('promo/store', [PromoController::class, 'store']);
Route::post('promo/update', [PromoController::class, 'update']);

Route::get('paket/getall', [PaketController::class, 'getAll']);
Route::get('paket/show', [PaketController::class, 'show']);
Route::post('paket/store', [PaketController::class, 'store']);
Route::post('paket/update', [PaketController::class, 'update']);
Route::post('paket/destroy', [PaketController::class, 'destroy']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
