<?php

namespace App\Services;

use App\Models\ContactInf;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Service class responsible for handling restaurant-related business logic.
 */
class RestaurantService
{
    /**
     * Fetch all restaurants with pagination.
     *
     * @return array An associative array containing the status, message, and data.
     */
    public function getAllRestaurants()
    {
        try {
            // Fetch all restaurants with their restaurant types, paginated by 10 results per page
            $restaurants = Restaurant::with('restaurantType')->paginate(10);

            return [
                'status' => 200,
                'message' => __('restaurant.all_restaurants_fetched'),
                'data' => $restaurants,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in fetching all restaurants: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_erorr')],
                ],
            ];
        }
    }

    /**
     * Fetch nearby restaurants along with their offers.
     *
     * @return array An associative array containing the status, message, and data.
     */
    public function getNearRestaurant($filteringData)
    {
        try {
            $user = Auth::user();

            // Retrieve location details with default values
            $latitude = $filteringData['latitude'] ?? $user->latitude;
            $longitude = $filteringData['longitude'] ?? $user->longitude;
            $radius = $filteringData['radius'] ?? $user->radius ?? 10; // Fixed incorrect default value

            // Fetch nearby restaurants and apply filtering
            $restaurants = Restaurant::nearby($latitude, $longitude, $radius)
                ->withAvg('ratings', 'rate')
                ->when(!empty($filteringData), function ($query) use ($filteringData) {
                    $query->filterBy($filteringData);
                })->with("image")
                ->paginate(10);

            return [
                'status' => 200,
                'message' => __('restaurant.nearby_restaurants_fetched'),
                'data' => $restaurants,
            ];

        } catch (\Exception $e) {
            // Improved error logging
            Log::error("Error fetching nearby restaurants: " . $e->getMessage(), ['exception' => $e]);

            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_error')],
                ],
            ];
        }
    }



    /**
     * Create a new restaurant record.
     *
     * @param array $data The validated data required for creating a restaurant.
     * @return array An associative array containing the status, message, and data.
     */
    public function createRestaurant($data)
    {
        try {
            DB::beginTransaction();

            // Create a new restaurant record
            $restaurant = Restaurant::create([
                'restaurant_name' => $data['restaurant_name'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'restaurantType_id' => $data['restaurantType_id'],
                'user_id' => $data['user_id'],
            ]);


            if (isset($data['image'])) {
                $image = $data['image'];
                $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('private_users/images', $imageName, 'public');
                $imageData = [
                    'mime_type' => $image->getClientMimeType(),
                    'image_path' => Storage::url($path),
                    'image_name' => $imageName,
                ];

                $restaurant->image()->create($imageData);
            }

            // Create the related ContactInf record
            $contactinf = ContactInf::create([
                'restaurant_id' => $restaurant->id,
                'whatsappNumber' => $data['whatsappNumber'],
                'phoneNumber1' => $data['phoneNumber1'],
                'phoneNumber2' => $data['phoneNumber2'],
                'email' => $data['email'],
            ]);

            return [
                'status' => 200,
                'message' => __('restaurant.restaurant_created'),
                'data' => $restaurant,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging
            Log::error("Error in creating restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_erorr')],
                ],
            ];
        }
    }


    /**
     * Update an existing restaurant record.
     *
     * @param Restaurant $restaurant The restaurant instance to update.
     * @param array $data The validated data for updating the restaurant.
     * @return array An associative array containing the status, message, and data.
     */
    public function updateRestaurant(Restaurant $restaurant, $data)
    {
        try {

            // Update the restaurant record with the provided data
            $restaurant->update([
                'restaurant_name' => $data['restaurant_name'] ?? $restaurant->restaurant_name,
                'latitude' => $data['latitude'] ?? $restaurant->latitude,
                'longitude' => $data['longitude'] ?? $restaurant->longitude,
                'restaurantType_id' => $data['restaurantType_id'] ?? $restaurant->restaurantType_id,
                'user_id' => $data['user_id']?? $restaurant->user_id,
            ]);

            // Update the related ContactInf record
            $restaurant->contactInf()->update([ // Ensure this relationship method is defined in Restaurant model
                'whatsappNumber' => $data['whatsappNumber'] ?? $restaurant->contactInf->whatsappNumber,
                'phoneNumber1' => $data['phoneNumber1'] ?? $restaurant->contactInf->phoneNumber1,
                'phoneNumber2' => $data['phoneNumber2'] ?? $restaurant->contactInf->phoneNumber2,
                'email' => $data['email'] ?? $restaurant->contactInf->email,
            ]);

            // Check if there's an image and update it
            if (isset($data['image'])) {
                // Delete the old image if it exists
                if ($restaurant->image) {
                    $restaurant->image()->delete();  // Correct method name here
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
                $restaurant->image()->create($imageData);
            }



            return [
                'status' => 200,
                'message' => __('restaurant.restaurant_updated'),
                'data' => $restaurant,
            ];
        } catch (\Exception $e) {


            // Log the error for debugging
            Log::error("Error in updating restaurant: " . $e->getMessage(), [
                'data' => $data, // Adding the input data for debugging purposes
                'exception' => $e,
            ]);

            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_error')],
                ],
            ];
        }
    }


    /**
     * Soft delete a restaurant.
     *
     * @param Restaurant $restaurant The restaurant instance to delete.
     * @return array An associative array containing the status and message.
     */
    public function forceDeleteRestaurant(Restaurant $restaurant)
    {
        try {
            // Perform soft delete
            $restaurant->delete();

            return [
                'status' => 200,
                'message' => __('restaurant.restaurant_deleted'),
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in deleting restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_erorr')],
                ],
            ];
        }
    }

    /**
     * Permanently delete a restaurant from storage.
     *
     * @param Restaurant $restaurant The restaurant instance to delete permanently.
     * @return array An associative array containing the status and message.
     */
    public function permanentDeleteRestaurant($restaurant)
    {
        try {

            $restaurant->forceDelete();
            return [
                'status' => 200,
                'message' => __('restaurant.restaurant_permanent_deleted'), // Permanent delete message
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in permanently deleting restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => [
                    'errorDetails' => [__('general.general_erorr')],
                ],
            ];
        }
    }
}
