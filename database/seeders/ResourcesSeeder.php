<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourcesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dashboard = Resource::create([
            'name' => 'dashboard',
            'display_name' => 'Dashboard',
            'description' => 'Dashboard',
        ]);

        $certificates = Resource::create([
            'name' => 'orders',
            'display_name' => 'Bestellungen',
            'description' => 'Bestellungen',
        ]);

        $nova = Resource::create([
            'name' => 'nova',
            'display_name' => 'Nova',
            'description' => 'Nova',
        ]);

        $telescope = Resource::create([
            'name' => 'telescope',
            'display_name' => 'Telescope',
            'description' => 'Telescope',
        ]);
    }
}
