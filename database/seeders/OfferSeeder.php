<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Offer;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        $faker = Faker::create();
        $meals = Meal::all();

        foreach ($meals as $meal) {
            Offer::create([
                'meal_id' => $meal->id,
                'new_price' => $faker->randomFloat(2, 5, 30),
                'from' => $faker->dateTimeBetween('-1 week', '+1 week'),
                'to' => $faker->dateTimeBetween('+1 week', '+4 weeks'),
            ]);
        }


    }
}
