<?php

use App\Http\Controllers\ChirpController;
use App\Models\User;
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

Route::get('/', [ChirpController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    auth()->login(User::first());
    Route::post('/', [ChirpController::class, 'store'])->name('chirp.store');
});
