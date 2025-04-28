<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;

class MealTypeService
{
    public function getMealType(Restaurant $restaurant)
    {
        try {
            // Fetch meal types with specific fields
            $mealTypes = $restaurant->mealTypes()
    ->select('meal_types.id', 'meal_types.mealTypeName', 'meal_types.mealTypeType')
    ->get();


            return [
                'status' => 200,
                'message' => __('mealtype.get_successful'),
                'data' => $mealTypes,
            ];
        } catch (\Exception $e) {
            Log::error("Error fetching meal types: " . $e->getMessage(), [
                'restaurant_id' => $restaurant->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

}
