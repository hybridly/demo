<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Like;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Chirps
|--------------------------------------------------------------------------
*/

Route::get('/', [ChirpController::class, 'index'])->name('index');
Route::post('/chirps', [ChirpController::class, 'store'])->name('chirp.store');
Route::get('/chirps/{chirp}', [ChirpController::class, 'show'])->name('chirp.show');
Route::post('/chirps/{chirp}/likes', Like\LikeChirpController::class)->name('chirp.like');
Route::delete('/chirps/{chirp}/likes', Like\UnlikeChirpController::class)->name('chirp.unlike');
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirp.destroy');

/*
|--------------------------------------------------------------------------
| User profile
|--------------------------------------------------------------------------
*/

Route::get('/users/{user}', Profile\ShowChirpsController::class)->name('users.show');
Route::get('/users/{user}/comments', Profile\ShowCommentsController::class)->name('users.show-comments');
Route::get('/users/{user}/likes', Profile\ShowLikesController::class)->name('users.show-likes');
