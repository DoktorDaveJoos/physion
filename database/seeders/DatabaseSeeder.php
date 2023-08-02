<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resource;
use App\Models\Role;
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
        // \App\Models\User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'David',
//            'email' => 'david@bauzertifikate.de',
//            'password' => bcrypt('testtest'),
//        ]);
//
//        User::factory()->create([
//            'name' => 'Hannes',
//            'email' => 'hannes@bauzertifikate.de',
//            'password' => bcrypt('testtest'),
//        ]);
//
//        Product::create(
//            [
//                'type' => 'certificate',
//                'name' => 'Verbrauchsausweis',
//                'short_name' => 'vrbr',
//                'description' => 'Verbrauchsorientierter Energieausweis',
//                'price' => 79.90,
//                'image' => null,
//                'image_alt' => null,
//            ]
//        );
//
//        Product::create(
//            [
//                'type' => 'certificate',
//                'name' => 'Bedarfsausweis',
//                'short_name' => 'bdrf',
//                'description' => 'Bedarfsorientierter Energieausweis',
//                'price' => 119.00,
//                'image' => null,
//                'image_alt' => null,
//            ]
//        );

        $role = Role::create(['name' => 'admin']);

        $resource = Resource::create([
            'name' => 'nova',
            'display_name' => 'Nova',
        ]);
        $role->resources()->attach($resource->id);

        $resource = Resource::create([
            'name' => 'telescope',
            'display_name' => 'Telescope',
        ]);
        $role->resources()->attach($resource->id);

        $resource = Resource::create([
            'name' => 'certificates',
            'display_name' => 'Energieausweise',
        ]);

        $role->resources()->attach($resource->id);

        $user = User::where('name', 'David')->first();
        $user->roles()->attach($role->id);
    }
}
