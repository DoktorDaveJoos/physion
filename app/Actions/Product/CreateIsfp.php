<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Building;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateIsfp
{

    use asAction;

    const DEFAULT_PRICE = 1600;
    const PRODUCT_NAME = 'isfp';

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
        string $bauantrag_date,
        string $power_of_attorney_path,
    ): void {
        $isfpProduct = Product::where('name', self::PRODUCT_NAME)->latest('created_at');

        if (!$isfpProduct) {
            $isfpProduct = Product::create([
                'name' => self::PRODUCT_NAME,
                'description' => 'Individueller Sanierungsfahrplan',
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

        $building->update([
            'bauantrag_date' => $bauantrag_date,
        ]);

        Isfp::create([
            'building_id' => $building->id,
            'customer_id' => $customer->id,
            'product_id' => $isfpProduct->id,
            'power_of_attorney_path' => $power_of_attorney_path,
        ]);
    }

}
