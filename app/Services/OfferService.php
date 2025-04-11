<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OfferService
{
    /**
     * Retrieve all available offers with related meal and restaurant details.
     *
     * @return array The status, message, and retrieved offers.
     */
    public function getOffer($data)
    {
        try {
            $data = request()->all(); // Get request data safely

            $user = Auth::user();
            $latitude = $data['latitude'] ?? $user->latitude;
            $longitude = $data['longitude'] ?? $user->longitude;
            $radius = $data['radius'] ?? "100000"; // Default radius if none is provided

            // Retrieve offers with meal & restaurant details
            $user = Auth::user();
            $latitude = $data['latitude'] ?? $user->latitude;
            $longitude = $data['longitude'] ?? $user->longitude;
            $radius = $data['radius'] ?? 100000; // تحويل إلى عدد صحيح

            $user = Auth::user();
            $latitude = $data['latitude'] ?? $user->latitude;
            $longitude = $data['longitude'] ?? $user->longitude;
            $radius = $data['radius'] ?? 100000; // تحويل إلى عدد صحيح

            $offers = Offer::whereHas('meal.restaurant', function ($query) use ($latitude, $longitude, $radius) {
                $query->nearby($latitude, $longitude, $radius);
            })
            ->with([
                'meal' => function ($query) {
                    $query->select('id', 'mealName', 'price', 'restaurant_id');
                },
                'meal.restaurant' => function ($query) {
                    $query->select('id', 'restaurant_name', 'latitude', 'longitude')
                          ->withAvg('ratings as avg_rating', 'rate');
                }
            ])
            ->paginate(10);




            return [
                'status' => 200,
                'message' => __('offer.offer_get_successful'), // Success message
                'data' => $offers, // Retrieved offer data
            ];
        } catch (\Exception $e) {
            // Log any errors encountered during execution
            Log::error("Error fetching offers: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'), // General error message
            ];
        }
    }

    /**
     * Create a new offer based on provided data.
     *
     * @param array $data Offer details including meal_id, price, and duration.
     * @return array The status, message, and newly created offer.
     */
    public function createOffer($data)
    {
        try {
            // Create a new offer with provided data
            $offer = Offer::create([
                'meal_id' => $data['meal_id'],
                'new_price' => $data['new_price'],
                'from' => $data['from'],
                'to' => $data['to'],
            ]);

            return [
                'status' => 200,
                'message' => __('offer.offer_create_successful'), // Success message
                'data' => $offer, // Created offer details
            ];
        } catch (\Exception $e) {
            // Log any errors encountered during execution
            Log::error("Error creating offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'), // General error message
            ];
        }
    }

    /**
     * Update an existing offer's details.
     *
     * @param array $data Updated offer information.
     * @param Offer $offer The existing offer instance.
     * @return array The status, message, and updated offer.
     */
    public function updateOffer($data, Offer $offer)
    {
        try {
            // Update the offer with new values if provided, otherwise keep old ones
            $offer->update([
                'new_price' => $data['new_price'] ?? $offer->new_price,
                'from' => $data['from'] ?? $offer->from,
                'to' => $data['to'] ?? $offer->to,
            ]);

            return [
                'status' => 200,
                'message' => __('offer.offer_update_successful'), // Success message
                'data' => $offer, // Updated offer details
            ];
        } catch (\Exception $e) {
            // Log any errors encountered during execution
            Log::error("Error updating offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'), // General error message
            ];
        }
    }

    /**
     * Delete an existing offer.
     *
     * @param Offer $offer The offer instance to be deleted.
     * @return array The status and message indicating success or failure.
     */
    public function deleteOffer(Offer $offer)
    {
        try {
            // Delete the specified offer
            $offer->delete();
            return [
                'status' => 200,
                'message' => __('offer.offer_delete_successful'), // Success message
            ];
        } catch (\Exception $e) {
            // Log any errors encountered during execution
            Log::error("Error deleting offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'), // General error message
            ];
        }
    }
}
