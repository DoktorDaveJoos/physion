<?php

namespace App\Nova\Actions;

use App\Models\Product;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Http\Requests\NovaRequest;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class AddSubscriptionToTeam extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     * @throws BindingResolutionException
     * @throws ApiErrorException
     * @throws IncompletePayment
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $client = app()->make(StripeClient::class);

        if ($models->count() > 1) {
            return Action::danger('Du kannst immer nur 1 Team verwalten!');
        }

        $products = Product::whereIn('id', $fields->produkte)->get();

        $priceIds = collect();
        $products->each(function (Product $product) use ($client, $priceIds) {
            $stripeProduct = $client->products->retrieve($product->stripe_product_id);

            ray($client->prices->retrieve($stripeProduct->default_price)->product);

            $priceIds->push($stripeProduct->default_price);
        });

        $models->each(function (Team $team) use ($products, $priceIds) {
            $subscription = $team->newSubscription('default');

            $priceIds->each(function ($priceId) use ($subscription) {
                $subscription->meteredPrice($priceId);
            });

            $subscription->create(null, [], [
                'collection_method' => 'send_invoice',
                'days_until_due' => 30,
                'payment_settings' => [
                    'payment_method_types' => ['customer_balance'],
                ],
            ]);
        });

        return Action::message('Erfolg!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $products = Product::where('recurring', true)->get();
        $options = $products->pluck('name', 'id')->toArray();

        return [
            MultiSelect::make('Produkte')
                ->options($options)->displayUsingLabels(),
        ];
    }
}
