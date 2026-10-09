<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::get('/', [BarangController::class, 'index'])
    ->name('barang.index');
Route::post('/keranjang/tambah/{barang}', [BarangController::class, 'tambah'])
    ->name('keranjang.tambah');
Route::get('/keranjang', [BarangController::class, 'keranjang'])
    ->name('keranjang.index');
Route::post('/keranjang/{barang}/ubah', [BarangController::class, 'ubahJumlah'])
    ->name('keranjang.ubah');
Route::post('/keranjang/{barang}/hapus', [BarangController::class, 'hapus'])
    ->name('keranjang.hapus');
Route::post('/keranjang/kosongkan', [BarangController::class, 'kosongkan'])
    ->name('keranjang.kosongkan');