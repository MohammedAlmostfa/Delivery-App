<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;

class MealService
{

    public function getMeal(Restaurant $restaurant)
    {
        try {

            $meals = $restaurant
                ->with([
                    'meals' => function ($query) {
                        $query->select('id', 'mealName', 'price', 'restaurant_id', 'mealType_id', 'time_of_prepare');
                    },
                    'meals.mealType' => function ($query) {
                        $query->select('id', 'mealTypeName', 'mealTypeType');
                    },
                ])
                ->paginate(10);

            return [
                'status' => 200,
                'message' => __('meal.meal_retrieved_successfully'),
                'data' => $meals,
            ];
        } catch (\Exception $e) {

            Log::error("Error retrieving meals: " . $e->getMessage());

            // إرجاع استجابة الخطأ
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }


    /**
     * Create a new meal record in the database.
     *
     * @param array $data Meal data to be stored.
     * @return array Response status and message.
     */
    public function createMeal($data)
    {
        try {
            // Create a meal record
            $meal = Meal::create([
                'mealName' => $data['mealName'],
                'description' => $data['description'],
                'price' => $data['price'],
                'mealType_id' => $data['mealType_id'],
                'restaurant_id' => $data['restaurant_id'],
                'time_of_prepare' => $data['time_of_prepare'],
            ]);

            // Success response
            return [
                'status' => 200,
                'message' => __('meal.meal_create_successful'),
                'data' => $data,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in creating meal: " . $e->getMessage());

            // Error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Update an existing meal record in the database.
     *
     * @param array $data Updated meal data.
     * @param Meal $meal The meal to be updated.
     * @return array Response status and message.
     */
    public function updateMeal($data, Meal $meal)
    {
        try {
            // Update the meal record
            $meal->update([
                'mealName' => $data['mealName'] ?? $meal->mealName,
                'description' => $data['description'] ?? $meal->description,
                'price' => $data['price'] ?? $meal->price,
                'mealType_id' => $data['mealType_id'] ?? $meal->mealType_id,
                'availability_status' => $data['availability_status'] ?? $meal->availability_status,
                'time_of_prepare' => $data['time_of_prepare'] ?? $meal->time_of_prepare,
            ]);

            // Success response
            return [
                'status' => 200,
                'message' => __('meal.meal_update_successful'),
                'data' => $meal,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in updating meal: " . $e->getMessage());

            // Error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Soft delete a meal record.
     *
     * @param Meal $meal The meal to be deleted.
     * @return array Response status and message.
     */
    public function forcedeleteMeal($meal)
    {
        try {
            // Soft delete the meal record
            $meal->delete();

            // Success response
            return [
                'status' => 200,
                'message' => __('meal.meal_delete_successful'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in deleting meal: " . $e->getMessage());

            // Error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Permanently delete a meal record from the database.
     *
     * @param Meal $meal The meal to be permanently deleted.
     * @return array Response status and message.
     */
    public function permanentDeleteMeal($meal)
    {
        try {
            // Permanently delete the meal record
            $meal->forceDelete();

            // Success response
            return [
                'status' => 200,
                'message' => __('meal.meal_permanent_deleted'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in permanently deleting meal: " . $e->getMessage());

            // Error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Restore a soft-deleted meal record.
     *
     * @param Meal $meal The meal to be restored.
     * @return array Response status and message.
     */
    public function restoreMeal($meal)
    {
        try {
            // Restore the meal record
            $meal->restore();

            // Success response
            return [
                'status' => 200,
                'message' => __('meal.meal_restored'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in restoring meal: " . $e->getMessage());

            // Error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }
}
