<?php

namespace Database\Seeders;

use App\Models\MealType;
use Illuminate\Database\Seeder;

class MealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mealTypes = ['دجاج', 'لحم', 'معكرونة', 'برغر', 'بيتزا', 'شوربة', 'سلطة', 'سندويشات', 'حلويات', 'مشروبات', 'وجبات سريعة'];

        foreach ($mealTypes as $mealType) {
            MealType::create([
                "mealTypeName" => $mealType
            ]);
        }
    }
}
