<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middlewars' => ['auth']], function () {
    Route::resource('supplier', App\Http\Controllers\SupplierController::class);
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('komponen', App\Http\Controllers\KomponenController::class);
    Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
});

Route::get('templete', function () {
    return view('layouts.dashboard');
});



Route::resource('pembayaran', PembayaranController::class);
