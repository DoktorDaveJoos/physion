<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'David',
            'last_name' => 'Joos',
            'email' => 'david@bauzertifikate.de',
            'password' => bcrypt('test'),
        ]);

        User::factory()->create([
            'first_name' => 'Hannes',
            'last_name' => 'Jungert',
            'email' => 'hannes@bauzertifikate.de',
            'password' => bcrypt('test'),
        ]);

//        $this->call([
//            ProductSeeder::class,
//            ResourcesSeeder::class,
//            TeamSeeder::class,
//        ]);
    }
}
