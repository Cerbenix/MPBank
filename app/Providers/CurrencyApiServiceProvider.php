<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CurrencyApiServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('CurrencyApiService', function ($app) {
            return new \App\Services\CurrencyApiService();
        });
    }


    public function boot()
    {
        //
    }
}
