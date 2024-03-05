<?php

namespace App\Observers;

use App\Models\Product;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class ProductObserver
{
    /**
     */
    public function __construct(
        public StripeClient $client
    ) {
    }

    /**
     * @throws ApiErrorException
     */
    public function created(Product $product): void
    {
        $product->stripe_product_id = self::createStripeProductFor($product, $this->client);
        $product->save();
    }

    /**
     * @throws ApiErrorException
     */
    public function updated(Product $product): void
    {
        if ($product->stripe_product_id === null) {
            $product->stripe_product_id = self::createStripeProductFor($product, $this->client);
            $product->save();
            return;
        }

        if ($product->isDirty('price')) {
            $config = [
                'product' => $product->stripe_product_id,
                'currency' => 'eur',
                'unit_amount' => $product->price * 100,
                'tax_behavior' => 'inclusive',
            ];

            if ($product->recurring) {
                $config['recurring'] = [
                    'aggregate_usage' => 'sum',
                    'interval' => 'month',
                    'usage_type' => 'metered',
                ];
            }

            $newPrice = $this->client->prices->create($config);

            $this->client->products->update(
                $product->stripe_product_id,
                [
                    'default_price' => $newPrice->id,
                ]
            );
        }

        if ($product->isDirty('name')) {
            $this->client->products->update(
                $product->stripe_product_id,
                [
                    'name' => $product->name,
                ]
            );
        }
    }


    /**
     * @throws ApiErrorException
     */
    private static function createStripeProductFor(Product $product, StripeClient $client): string
    {
        $stripeProduct = $client->products->create([
            'name' => $product->name,
        ]);

        $config = [
            'product' => $stripeProduct->id,
            'currency' => 'eur',
            'unit_amount' => $product->price * 100,
            'tax_behavior' => 'inclusive',
        ];

        if ($product->recurring) {
            $config['recurring'] = [
                'aggregate_usage' => 'sum',
                'interval' => 'month',
                'usage_type' => 'metered',
            ];
        }

        $price = $client->prices->create($config);

        $client->products->update(
            $stripeProduct->id,
            [
                'default_price' => $price->id,
            ]
        );

        return $stripeProduct->id;
    }

}
