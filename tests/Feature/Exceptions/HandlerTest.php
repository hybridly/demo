<?php

use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

test('exceptions do not return hybrid responses in the specified environments', function (string $environment) {
    app()->detectEnvironment(fn () => $environment);

    Route::get($path = '/route-that-triggers-exception', function () {
        throw new \Exception('Test exception');
    });

    get($path)->assertNotHybrid();
})->with(['local', 'testing']);

test('exceptions return hybrid responses in the specified environments', function (string $environment) {
    app()->detectEnvironment(fn () => $environment);

    Route::get($path = '/route-that-triggers-exception', function () {
        throw new \Exception('Test exception');
    });

    get($path)
        ->assertHybridView('security.error')
        ->assertHybridProperty('status', 500);
})->with(['production']);

test('a redirection back to the previous url with a flash message happens when session is expired in the specified environments', function ($environment) {
    app()->detectEnvironment(fn () => 'production');

    Route::get($path = '/route-that-triggers-exception', function () {
        throw new \Illuminate\Session\TokenMismatchException();
    });

    get($path)
        ->assertNotHybrid()
        ->assertRedirect()
        ->assertSessionHas('error', 'Your session has expired. Please refresh the page.');
})->with(['local', 'testing', 'production']);
