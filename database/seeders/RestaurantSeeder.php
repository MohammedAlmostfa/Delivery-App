<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Restaurant::create([
                'restaurant_name' => $faker->company,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'restaurantType_id' => $faker->numberBetween(1, 5), // Replace with valid IDs from the RestaurantType table
                'user_id' => $faker->numberBetween(1, 10), // Replace with valid IDs from the User table
            ]);
        }
    }
}
