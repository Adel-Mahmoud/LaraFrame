<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domains\Users\Models\UserEntity;
use Faker\Factory as Faker;

class FakeUsersSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create();
        // for ($i = 0; $i < 10; $i++) {
        //     UserEntity::create([
        //         'name' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'password' => Hash::make('Password123!')
        //     ]);
        // }
    }
}
