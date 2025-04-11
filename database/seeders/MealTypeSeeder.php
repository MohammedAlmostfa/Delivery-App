<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeds the meal_types table by creating meal types
     * for each category defined in the $mealCategories array.
     *
     * @return void
     */
    public function run(): void
    {
        // Define meal categories where the key represents the category type
        // 0: Breakfast, 1: Lunch, 2: Dinner, 3: Desserts, 4: Drinks
        $mealCategories = [
            'فطور' => ['بيض', 'فول', 'توست', 'فطائر', 'لبنة', 'عسل', 'زبادي'],
            'غداء' => ['دجاج', 'لحم', 'معكرونة', 'برغر', 'بيتزا', 'شوربة', 'سلطة', 'طاجن', 'مناسف'],
            'عشاء' => ['سندويشات', 'وجبات خفيفة', 'سمك مشوي', 'بيتزا', 'مأكولات بحرية'],
            'حلويات' => ['كنافة', 'بقلاوة', 'مهلبية', 'تشيز كيك'],
            'مشروبات' => ['غازية', 'طبيعي', 'عصير', 'ميلك شيك']
        ];

        // Loop through each category type and create meal types accordingly.
        foreach ($mealCategories as $mealTypeType => $mealTypes) {
            foreach ($mealTypes as $mealTypeName) {
                MealType::create([
                    "mealTypeName" => $mealTypeName,
                    "mealTypeType" => $mealTypeType // This represents the meal category (e.g., Breakfast, Lunch, etc.)
                ]);
            }
        }
    }
}
