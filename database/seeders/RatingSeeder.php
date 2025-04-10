<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Rating::create([
                'rate' => $faker->numberBetween(1, 5),
                'review' => $faker->sentence,
                'user_id' => $faker->numberBetween(1, 10),
                'restaurant_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
