<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
             MealTypeSeeder::class,
             RestaurantTypeSeeder::class,
             RoleAndPermissionSeeder::class,
             UserSeeder::class,
             RestaurantSeeder::class,
             MealSeeder::class,
             RatingSeeder::class,
             OfferSeeder::class,
         ]);

    }
}
