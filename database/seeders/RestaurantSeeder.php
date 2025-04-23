<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RestaurantSeeder extends Seeder
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

        $users = User::all();

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $image = $images[array_rand($images)];

            $restaurant = Restaurant::create([
                'restaurant_name' => $faker->company,

                'latitude' => $faker->latitude(34.95, 35.05),
                'longitude' => $faker->longitude(34.95, 35.05),
                'restaurantType_id' => $faker->numberBetween(1, 5),
                'user_id' => $user->id,
            ]);
            $restaurant->image()->create($image);
        }
    }
}
