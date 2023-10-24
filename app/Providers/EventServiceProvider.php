<?php

namespace App\Providers;

use App\Events\CustomerUpdatedFromStripe;
use App\Events\PaymentCreated;
use App\Listeners\HandleCustomerFromStripe;
use App\Listeners\SendEmailVerificationNotification;
use App\Models\Customer;
use App\Models\Product;
use App\Observers\CustomerObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
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
            HandleCustomerFromStripe::class,
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
