<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Like\LikeChirpController;
use App\Http\Controllers\Like\UnlikeChirpController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\HandleMonolikitRequests;
use Illuminate\Support\Facades\Route;

/*

---------------------------------------------------------------------------
:: Chirps
---------------------------------------------------------------------------

*/

Route::group([
    'middleware' => [
        'auth',
        HandleMonolikitRequests::class,
    ],
], function () {
    Route::get('/', [ChirpController::class, 'index'])->name('index');
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirp.store');
    Route::get('/chirp/{chirp}', [ChirpController::class, 'show'])->name('chirp.show');
    Route::post('/chirps/{chirp}/likes', LikeChirpController::class)->name('chirp.like');
    Route::delete('/chirps/{chirp}/likes', UnlikeChirpController::class)->name('chirp.unlike');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirp.destroy');
});

/*

---------------------------------------------------------------------------
:: Security
---------------------------------------------------------------------------

*/

Route::group([
    'middleware' => 'guest',
], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

if (!app()->isproduction()) {
    Route::get('/dev/login/{id?}', [LoginController::class, 'dev_login']);
}
