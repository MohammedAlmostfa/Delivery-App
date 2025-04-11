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
        $faker = Faker::create();

        $users = User::all(); // استرجاع جميع المستخدمين لإنشاء المطاعم بالقرب منهم

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random(); // اختيار مستخدم عشوائي

            Restaurant::create([
                'restaurant_name' => $faker->company,
                'latitude' => $faker->latitude($user->latitude - 0.05, $user->latitude + 0.10),
                'longitude' => $faker->longitude($user->longitude - 0.05, $user->longitude + 0.10),
                'restaurantType_id' => $faker->numberBetween(1, 5),
                'user_id' => $user->id,
            ]);
        }
    }
}
