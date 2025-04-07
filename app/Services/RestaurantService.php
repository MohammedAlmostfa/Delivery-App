<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth; // Corrected import
use Illuminate\Support\Facades\Log;

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
                'message' => 'All restaurants fetched successfully.',
                'data' => $restaurants,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in fetching all restaurants: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => 'An error occurred while fetching the restaurants.',
            ];
        }
    }

    /**
     * Fetch nearby restaurants along with their offers.
     *
     * @return array An associative array containing the status, message, and data.
     */
    public function getNearbyRestaurantsAndOffers()
    {
        try {
            // Fetch all restaurants with their offers
            $restaurants = Restaurant::with('offers')->get();

            return [
                'status' => 200,
                'message' => 'Nearby restaurants and offers fetched successfully.',
                'data' => $restaurants,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in fetching nearby restaurants and offers: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => 'An error occurred while fetching the restaurants and offers.',
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
            // Create a new restaurant record
            $restaurant = Restaurant::create([
                'restaurant_name' => $data['restaurant_name'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'restaurantType_id' => $data['restaurantType_id'],
                'user_id' => Auth::user()->id, // Get the authenticated user's ID
            ]);

            return [
                'status' => 200,
                'message' => 'Restaurant created successfully.',
                'data' => $restaurant,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in creating restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while creating the restaurant.',
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
                'user_id' => Auth::user()->id, // Update with the current authenticated user's ID
            ]);

            return [
                'status' => 200,
                'message' => 'Restaurant updated successfully.',
                'data' => $restaurant,
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in updating restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while updating the restaurant.',
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
                'message' => 'Restaurant deleted successfully.',
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in deleting restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while deleting the restaurant.',
            ];
        }
    }

    /**
     * Permanently delete a restaurant from storage.
     *
     * @param Restaurant $restaurant The restaurant instance to delete permanently.
     * @return array An associative array containing the status and message.
     */
    public function permanentDeleteRestaurant(Restaurant $restaurant)
    {
        try {
            // Perform permanent deletion
            $restaurant->forceDelete();

            return [
                'status' => 200,
                'message' => 'Restaurant permanently deleted successfully.',
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in permanently deleting restaurant: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while permanently deleting the restaurant.',
            ];
        }
    }
}
