<?php

namespace App\Providers;

use App\Models\Team;
use Hidehalo\Nanoid\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
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

        $this->app->singleton(StripeClient::class, function () {
            Stripe::setApiKey(config('stripe.api_key'));
            return new StripeClient(config('stripe.api_key'));
        });

        $this->app->bind(Client::class, function () {
            return new Client();
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Team::class);
        Cashier::calculateTaxes();
    }
}
