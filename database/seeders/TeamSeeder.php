<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Team::create([
            'name' => 'ABC Immobilien',
            'personal_team' => false,
            'user_id' => User::where('email', 'david@bauzertifikate.de')->first()->id,
        ]);
    }
}
