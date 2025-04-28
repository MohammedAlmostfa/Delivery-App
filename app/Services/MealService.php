<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MealService
{
    /**
     * Retrieve meals for a specific restaurant with pagination.
     *
     * @param Restaurant $restaurant The restaurant from which meals are fetched.
     * @return array The response containing the status, message, and paginated meals.
     */
    public function getMeal($id, $mealType)
    {
        try {

            $restaurant = Restaurant::withAvg('ratings', 'rate')->findOrFail($id);


            $meals = $restaurant->meals()
                ->where('mealType_id', $mealType)
                ->select('id', 'mealName', 'price', 'restaurant_id', 'mealType_id', 'time_of_prepare')
                ->with([
                    'mealType:id,mealTypeName,mealTypeType',
                    'image'
                ])
                ->paginate(10);


            $meals->each(function ($meal) use ($restaurant) {
                $meal->restaurant_rate_avg = $restaurant->ratings_avg_rate ?? 0;
            });

            return [
                'status' => 200,
                'message' => __('meal.meal_retrieved_successfully'),
                'data' => $meals,
            ];
        } catch (\Exception $e) {
            // سجل الخطأ مع التفاصيل
            Log::error("Error retrieving meals: " . $e->getMessage(), [
                'restaurant_id' => $id,
                'mealType_id' => $mealType,
            ]);

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Get a random meal from the meals ordered by the authenticated user.
     *
     * @return array The response containing the status, message, and a random meal.
     */
    public function getRandomMeal()
    {
        try {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Get all meals the user has ordered
            $meals = Meal::whereHas('orders', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['restaurant' => function ($query) {
                    $query->select('id', 'restaurant_name');
                }, 'image'])
                ->select('id', 'mealName', 'price', 'restaurant_id')
                ->get();

            // Check if no meals are found for the user
            if ($meals->isEmpty()) {
                return [
                    'status' => 404,
                    'message' => __('meal.no_meals_found'),
                ];
            }

            // Select a random meal from the ordered meals
            $randomMeal = $meals->random();

            // Return success response with the random meal
            return [
                'status' => 200,
                'message' => __('meal.meal_retrieved_successfully'),
                'data' => $randomMeal,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error retrieving meals: " . $e->getMessage());

            // Return error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Create a new meal record in the database.
     *
     * @param array $data The meal data to be stored.
     * @return array The response status and message.
     */
    public function createMeal($data)
    {
        try {
            // Create a meal record in the database
            $meal = Meal::create([
                'mealName' => $data['mealName'],
                'description' => $data['description'],
                'price' => $data['price'],
                'mealType_id' => $data['mealType_id'],
                'restaurant_id' => $data['restaurant_id'],
                'time_of_prepare' => $data['time_of_prepare'],
            ]);

            // Handle image upload if provided
            if (isset($data['image'])) {
                $image = $data['image'];
                $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('private_users/images', $imageName, 'public');
                $imageData = [
                    'mime_type' => $image->getClientMimeType(),
                    'image_path' => Storage::url($path),
                    'image_name' => $imageName,
                ];

                // Create the image record associated with the meal
                $meal->image()->create($imageData);
            }

            // Return success response
            return [
                'status' => 200,
                'message' => __('meal.meal_create_successful'),
                'data' => $data,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error in creating meal: " . $e->getMessage());

            // Return error response
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
     * @return array The response status and message.
     */
    public function updateMeal($data, Meal $meal)
    {
        try {
            // Update the meal with new data or keep the existing values
            $meal->update([
                'mealName' => $data['mealName'] ?? $meal->mealName,
                'description' => $data['description'] ?? $meal->description,
                'price' => $data['price'] ?? $meal->price,
                'mealType_id' => $data['mealType_id'] ?? $meal->mealType_id,
                'availability_status' => $data['availability_status'] ?? $meal->availability_status,
                'time_of_prepare' => $data['time_of_prepare'] ?? $meal->time_of_prepare,
            ]);

            // Handle image upload if provided
            if (isset($data['image'])) {
                // Delete the old image if it exists
                if ($meal->image) {
                    $meal->image()->delete();
                }

                // Upload the new image
                $image = $data['image'];
                $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('private_users/images', $imageName, 'public');
                $imageData = [
                    'mime_type' => $image->getClientMimeType(),
                    'image_path' => Storage::url($path),
                    'image_name' => $imageName,
                ];

                // Create a new image record
                $meal->image()->create($imageData);
            }

            // Return success response
            return [
                'status' => 200,
                'message' => __('meal.meal_update_successful'),
                'data' => $meal,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in updating meal: " . $e->getMessage());

            // Return error response
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
     * @return array The response status and message.
     */
    public function forcedeleteMeal($meal)
    {
        try {
            // Soft delete the meal
            $meal->delete();

            // Return success response
            return [
                'status' => 200,
                'message' => __('meal.meal_delete_successful'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in deleting meal: " . $e->getMessage());

            // Return error response
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
     * @return array The response status and message.
     */
    public function permanentDeleteMeal($meal)
    {
        try {
            // Permanently delete the meal
            $meal->forceDelete();

            // Return success response
            return [
                'status' => 200,
                'message' => __('meal.meal_permanent_deleted'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in permanently deleting meal: " . $e->getMessage());

            // Return error response
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
     * @return array The response status and message.
     */
    public function restoreMeal($meal)
    {
        try {
            // Restore the soft-deleted meal
            $meal->restore();

            // Return success response
            return [
                'status' => 200,
                'message' => __('meal.meal_restored'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in restoring meal: " . $e->getMessage());

            // Return error response
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }
}
