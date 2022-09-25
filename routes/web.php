<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Like\LikeChirpController;
use App\Http\Controllers\Like\UnlikeChirpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Chirps
|--------------------------------------------------------------------------
*/

Route::get('/', [ChirpController::class, 'index'])->name('index');
Route::post('/chirps', [ChirpController::class, 'store'])->name('chirp.store');
Route::get('/chirps/{chirp}', [ChirpController::class, 'show'])->name('chirp.show');
Route::post('/chirps/{chirp}/likes', LikeChirpController::class)->name('chirp.like');
Route::delete('/chirps/{chirp}/likes', UnlikeChirpController::class)->name('chirp.unlike');
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirp.destroy');
