<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Services\stripeServices;


class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(stripeServices::class, function ($app) {
        return new stripeServices();
      });
    }
}
