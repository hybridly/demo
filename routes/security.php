<?php

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Security;

Route::get('/login', [Security\AuthenticationController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [Security\AuthenticationController::class, 'create'])->middleware('guest')->name('login.attempt');
Route::post('/logout', [Security\AuthenticationController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/bypass-login/{user?}', Security\BypassAuthenticationController::class)->name('login.bypass');
