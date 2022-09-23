<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot()
    {
        $this->routes(function () {
            Route::middleware('web', 'auth')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/security.php'));
        });
    }
}
