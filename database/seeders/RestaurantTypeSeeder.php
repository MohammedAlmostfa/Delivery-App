<?php

namespace Database\Seeders;

use App\Models\RestaurantType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // قائمة بأنواع المطاعم
        $restaurants = [
            'شرقي',
            'غربي',
            'إيطالي',
            'صيني',
            'مكسيكي',
            'هندي',
            'لبناني',
            'تركي',
            'فرنسي',
            'بحري',
        ];


        foreach ($restaurants as $restaurant) {
            RestaurantType::create([
                'restaurantTypeName' => $restaurant
            ]);
        }
    }
}
