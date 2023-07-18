<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\supplier;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['auth'])->group(function() {
    Route::get('', 'App\Http\Controllers\penjualan@index');
    Route::resource('supplier', 'App\Http\Controllers\supplier');
    Route::resource('barang', 'App\Http\Controllers\barang');
    Route::resource('barang-opname', 'App\Http\Controllers\barang_opname');
    Route::resource('pembelian', 'App\Http\Controllers\pembelian');
    Route::resource('pembelian-detail', 'App\Http\Controllers\pembelian_detail');
    Route::resource('penjualan', 'App\Http\Controllers\penjualan');
    Route::resource('penjualan-detail', 'App\Http\Controllers\penjualan_detail');
    Route::resource('user', 'App\Http\Controllers\user');
    Route::resource('pengaturan', 'App\Http\Controllers\pengaturan');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
// Auth::routes();

Auth::routes(['register' => false, 'reset' => false]);
