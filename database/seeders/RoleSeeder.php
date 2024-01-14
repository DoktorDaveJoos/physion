<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Owner of the application',
        ]);

        Role::create([
            'name' => 'User',
            'description' => 'User of the application',
        ]);

        Role::create([
            'name' => 'Customer',
            'description' => 'Guest of the application',
        ]);

        $david = User::where('email', '=', 'david@bauzertifikate.de')->first();
        $david->roles()->attach($admin);
    }
}
