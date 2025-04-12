<?php

namespace Database\Seeders;

use App\Models\Meal;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Meal::create([
                'mealName' => $faker->word,
                'price' => $faker->randomFloat(2, 5, 50),
                'description' => $faker->sentence,
                'mealType_id' => $faker->numberBetween(1, 10),
                'restaurant_id' => $faker->numberBetween(1, 5),
                'availability_status' => $faker->randomElement([
                    'Within less than an hour',
                    'Available',
                    'Within several hours',
                    'For the next day'
                ]),
     'time_of_prepare' => gmdate("H:i:s", $faker->numberBetween(10, 60) * 60),

            ]);
        }
    }
}
