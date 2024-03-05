<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Building;
use App\Models\Bza;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBza
{

    use asAction;

    const DEFAULT_PRICE = 1000;
    const PRODUCT_NAME = 'bza';

    public function handle(
        Building $building,
        string $type,
        string $title,
        string $first_name,
        string $last_name,
        string $street,
        string $house_number,
        string $postal_code,
        string $city,
        string $country,
        string $phone,
        string $email,
        string $power_of_attorney_path,
    ): void {

        $bzaProduct = Product::where('name', self::PRODUCT_NAME)->latest('created_at');

        if (!$bzaProduct) {
            $bzaProduct = Product::create([
                'name' => self::PRODUCT_NAME,
                'description' => 'Bestätigung zum Antrag',
                'price' => self::DEFAULT_PRICE,
                'recurring' => false,
            ]);
        }

        $customer = Customer::create([
            'type' => $type,
            'title' => $title,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address_line_1' => $street.' '.$house_number,
            'zip' => $postal_code,
            'city' => $city,
            'country' => $country,
            'phone' => $phone,
            'email' => $email,
        ]);

        Bza::create([
            'building_id' => $building->id,
            'customer_id' => $customer->id,
            'product_id' => $bzaProduct->id,
            'power_of_attorney_path' => $power_of_attorney_path,
        ]);

    }

}
