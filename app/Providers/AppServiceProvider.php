<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\CliDumper;
use Illuminate\Foundation\Http\HtmlDumper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Model::unguard();
        Model::shouldBeStrict();

        // https://github.com/laravel/framework/pull/44623
        HtmlDumper::resolveDumpSourceUsing(fn () => null);
        CliDumper::resolveDumpSourceUsing(fn () => null);
    }
}
