<?php

namespace App\Providers;

use App\Services\Order\OrderService;
use App\Services\Stripe\StripeService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\StripeClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderService::class, function () {
            return new OrderService();
        });

        $this->app->singleton(StripeClient::class, function () {
            Stripe::setApiKey(config('stripe.api_key'));
            return new StripeClient(config('stripe.api_key'));
        });

        $this->app->bind(StripeService::class, function($app) {
            return new StripeService($app->make(StripeClient::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
