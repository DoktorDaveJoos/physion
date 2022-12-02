<?php

namespace App\Providers;

use App\Services\Customer\CustomerService;
use App\Services\DeadLetterService;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentService;
use Cassandra\Type\Custom;
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
        $this->app->bind(OrderService::class, function() {
            return new OrderService();
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
