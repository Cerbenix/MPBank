<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CryptoApiServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('CryptoApiService', function ($app) {
            return new \App\Services\CryptoApiService();
        });
    }


    public function boot()
    {
        //
    }
}
