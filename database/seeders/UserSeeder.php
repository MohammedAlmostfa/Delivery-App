<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (['admin', 'manager', 'user'] as $role) {
            User::create([
                'name' => $role,
                'phone' => substr($faker->numerify('##########'), 0, 10),
                'email' => "{$role}User@gmail.com",
                'password' => bcrypt('P@ssw0rd123'),
                'latitude' => $faker->latitude, // موقع عشوائي أولي
                'longitude' => $faker->longitude,
            ])->assignRole($role);
        }

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'phone' => substr($faker->numerify('##########'), 0, 10),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('P@ssw0rd123'),
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ])->assignRole($faker->randomElement(['admin', 'user', 'manager']));
        }
    }
}
