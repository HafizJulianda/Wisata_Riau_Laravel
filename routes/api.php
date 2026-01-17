<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\WisataApiController;

Route::get('/wisata', [WisataApiController::class, 'index_wisata']);
Route::get('/penginapan', [WisataApiController::class, 'index_penginapan']);
Route::get('/restoran', [WisataApiController::class, 'index_restoran']);
Route::post('/register', [PenggunaController::class, 'register']);
Route::post('/login', [PenggunaController::class, 'login']);
Route::post('/change-password-no-old', [PenggunaController::class, 'changePasswordWithoutOld']);
Route::delete('/delete-account', [PenggunaController::class, 'deleteAccount']);