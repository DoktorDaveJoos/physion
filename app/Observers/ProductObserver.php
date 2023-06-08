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
            $newPrice = $this->client->prices->create([
                'product' => $product->stripe_product_id,
                'currency' => 'eur',
                'unit_amount' => $product->price * 100,
                'tax_behavior' => 'inclusive',
            ]);

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

        $client->prices->create([
            'product' => $stripeProduct->id,
            'currency' => 'eur',
            'unit_amount' => $product->price * 100,
            'tax_behavior' => 'inclusive',
        ]);

        return $stripeProduct->id;
    }

}
