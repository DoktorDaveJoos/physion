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

        $this->app->bind(DeadLetterService::class, function() {
            return new DeadLetterService();
        });

        $this->app->bind(PaymentService::class, function($app) {
            return new PaymentService($app->make(DeadLetterService::class));
        });

        $this->app->bind(OrderService::class, function($app) {
            return new OrderService($app->make(DeadLetterService::class));
        });

        $this->app->bind(CustomerService::class, function($app) {
            return new CustomerService($app->make(DeadLetterService::class));
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
