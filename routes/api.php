<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\MlController;
use App\Http\Controllers\TgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::any('auth/login', 'login')->name('login');
    Route::post('auth/register', 'register');
    Route::post('auth/logout', 'logout');
    Route::post('auth/refresh', 'refresh');
    Route::post('auth/me', 'me');
});

Route::controller(FolderController::class)->group(function () {
    Route::post('folder', 'createFolder');
    Route::get('folders', 'getFolders');
    Route::get('folders/{id}/files', 'getFiles');
    Route::get('file/{id}', 'getFiles');
    Route::delete('file/error/{id}', 'deleteError');
    Route::get('search/folders', 'searchFolder');
});

Route::controller(MlController::class)->group(function () {
    Route::post('folder/{id}/get-info', 'getInfo');
    Route::post('folder/{id}/send-message', 'sendMessage');
    Route::get('test', 'sendMessage');
});

Route::controller(TgController::class)->group(function () {
    Route::post('error', 'sendErrors');
});