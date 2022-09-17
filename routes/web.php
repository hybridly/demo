<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Like\LikeChirpController;
use App\Http\Controllers\Like\UnlikeChirpController;
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

Route::middleware([])->group(function () {
    Route::get('/', [ChirpController::class, 'index'])->name('index');
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirp.store');
    Route::get('/chirp/{chirp}', [ChirpController::class, 'show'])->name('chirp.show');
    Route::post('/chirps/{chirp}/likes', LikeChirpController::class)->name('chirp.like');
    Route::delete('/chirps/{chirp}/likes', UnlikeChirpController::class)->name('chirp.unlike');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirp.destroy');
});
