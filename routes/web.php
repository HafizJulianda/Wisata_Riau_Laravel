<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\RestoranController;
use App\Http\Controllers\WisataController;

Route::resource('penginapan', PenginapanController::class);
Route::resource('restoran', RestoranController::class);
Route::resource('wisata', WisataController::class);
Route::post('/change-password', [PenggunaController::class, 'changePassword']);

Route::get('/', function () {
    return redirect('/penginapan');
});

Route::get('/', function () {
    return redirect('/penginapan'); // langsung ke halaman data
});