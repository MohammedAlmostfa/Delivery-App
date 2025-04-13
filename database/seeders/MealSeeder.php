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

        $images = [
            [
                'image_name' => 'ceb457975b293aa4bd9fd5d7a0dff8a2',
                'image_path' => '//i.pinimg.com/736x/ce/b4/57',
                'mime_type' => 'jpg',
            ],
            [
                'image_name' => 'b82ef23538493d6911a5ad7d0d0c4f2e',
                'image_path' => '//i.pinimg.com/736x/b8/2e/f2/',
                'mime_type' => 'jpg',
            ],
            [
                'image_name' => 'cb02dbc732e27b8135ef5b65a81c8e45',
                'image_path' => '//i.pinimg.com/736x/cb/02/db/',
                'mime_type' => 'jpg',
            ],
            [
                'image_name' => 'd34337ea390f116247c3cd4719abdbd2',
                'image_path' => '//i.pinimg.com/474x/d3/43/37/',
                'mime_type' => 'jpg',
            ],
        ];


        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $image = $images[array_rand($images)];

            $meal =  Meal::create([
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
            $meal->image()->create($image);
        }
    }
}
