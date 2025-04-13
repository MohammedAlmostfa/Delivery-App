<?php

namespace App\Services;

use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * Create a new rating.
     *
     * @param array $data Rating details including rate, review, and restaurant_id.
     * @return array Response with status and rating data.
     */
    public function createRating(array $data)
    {
        try {
            $user = Auth::user();

            $rating = Rating::create([
                'rate' => $data['rate'],
                'review' => $data['review'],
                'user_id' => $user->id,
                'restaurant_id' => $data['restaurant_id'],
            ]);

            return [
                'status' => 200,
                'message' => __('rating.created_successfully'),
                'data' => $rating
            ];

        } catch (\Exception $e) {
            Log::error("Error creating rating: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Update an existing rating.
     *
     * @param array $data Updated rating details.
     * @param Rating $rating The rating to update.
     * @return array
     */
    public function updateRating(array $data, Rating $rating)
    {
        try {
            $rating->update([
                'rate' => $data['rate'] ?? $rating->rate,
                'review' => $data['review'] ?? $rating->review,
            ]);

            return [
                'status' => 200,
                'message' => __('rating.update_success'),
                'data' => $rating->fresh(),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating rating: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Delete a rating.
     *
     * @param Rating $rating
     * @return array
     */
    public function deleteRating(Rating $rating)
    {
        try {
            $rating->delete();

            return [
                'status' => 200,
                'message' => __('general.delete_success'),
            ];

        } catch (\Exception $e) {
            Log::error("Error deleting rating ID {$rating->id}: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.delete_error'),
            ];
        }
    }
}
