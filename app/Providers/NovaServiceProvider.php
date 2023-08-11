<?php

namespace App\Providers;

use App\Nova\Bdrf;
use App\Nova\Customer;
use App\Nova\Dashboards\Main;
use App\Nova\Order;
use App\Nova\Product;
use App\Nova\Team;
use App\Nova\User;
use App\Nova\Vrbr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Bestellungen', [
                    MenuItem::resource(Order::class),
                    MenuItem::resource(Vrbr::class),
                    MenuItem::resource(Bdrf::class),
                    MenuItem::resource(Customer::class),

                ])->collapsable(),

                MenuSection::make('Admin', [
                    MenuItem::resource(Product::class),
                    MenuItem::resource(User::class),
                    MenuItem::resource(Team::class),
                    MenuItem::externalLink('Stripe', 'https://dashboard.stripe.com/test/payments'),
                ])->collapsable(),

//                MenuSection::make('Content', [
//                    MenuItem::resource(Series::class),
//                    MenuItem::resource(Release::class),
//                ])->icon('document-text')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'david@bauzertifikate.de',
                'hannes@bauzertifikate.de'
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
