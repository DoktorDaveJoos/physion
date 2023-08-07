<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::create(
            [
                'type' => 'certificate',
                'name' => 'Verbrauchsausweis',
                'short_name' => 'vrbr',
                'description' => 'Verbrauchsorientierter Energieausweis',
                'price' => 79.90,
                'image' => null,
                'image_alt' => null,
            ]
        );

        Product::create(
            [
                'type' => 'certificate',
                'name' => 'Bedarfsausweis',
                'short_name' => 'bdrf',
                'description' => 'Bedarfsorientierter Energieausweis',
                'price' => 119.90,
                'image' => null,
                'image_alt' => null,
            ]
        );
    }
}
