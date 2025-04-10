<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;

class OfferService
{
    public function createOffer($data)
    {
        try {
            $offer = Offer::create([
                'meal_id' => $data['meal_id'],
                'new_price' => $data['new_price'],
                'from' => $data['from'],
                'to' => $data['to'],
            ]);

            return [
                'status' => 200,
                'message' => __('offer.offer_create_successful'),
                'data' => $offer,
            ];
        } catch (\Exception $e) {
            Log::error("Error creating offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    public function updateOffer($data, Offer $offer)
    {
        try {
            $offer->update([
                'new_price' => $data['new_price'] ?? $offer->new_price,
                'from' => $data['from'] ?? $offer->from,
                'to' => $data['to'] ?? $offer->to,
            ]);

            return [
                'status' => 200,
                'message' => __('offer.offer_update_successful'),
                'data' => $offer,
            ];
        } catch (\Exception $e) {
            Log::error("Error updating offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    public function deleteOffer(Offer $offer)
    {
        try {
            $offer->delete();
            return [
                'status' => 200,
                'message' => __('offer.offer_delete_successful'),
            ];
        } catch (\Exception $e) {
            Log::error("Error deleting offer: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }
}
