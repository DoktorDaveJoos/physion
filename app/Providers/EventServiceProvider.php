<?php

namespace App\Providers;

use App\Events\CustomerCreated;
use App\Events\PaymentCreated;
use App\Models\Customer;
use App\Models\Product;
use App\Observers\CustomerObserver;
use App\Observers\ProductObserver;
use App\Services\Customer\CreateCustomer;
use App\Services\Order\SetOrderPaidByCustomer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentCreated::class => [
            CreateCustomer::class,
        ],
        CustomerCreated::class => [
            SetOrderPaidByCustomer::class,
        ],
    ];

    protected $observers = [
        Product::class => [
            ProductObserver::class,
        ],
        Customer::class => [
            CustomerObserver::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
