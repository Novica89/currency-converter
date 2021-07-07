<?php

namespace App\Providers;

use App\Interfaces\ExchangeRateApi;
use App\Repositories\ExchangeRateApiRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExchangeRateApi::class, ExchangeRateApiRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
