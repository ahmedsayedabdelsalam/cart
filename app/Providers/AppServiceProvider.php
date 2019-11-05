<?php

namespace App\Providers;

use App\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Cart::class, function ($app) {
            return new Cart(auth('api')->user());
        });
    }
}
