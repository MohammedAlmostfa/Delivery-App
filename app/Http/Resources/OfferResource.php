<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meal_name' => $this->meal->mealName,
            'old_price' => $this->meal->price,
            'restaurant_name' => $this->meal->restaurant->restaurant_name,
            'avg_restaurant_rating' => $this->meal->restaurant->avg_restaurant_rating,
            'meal_id' => $this->meal_id,
            'new_price' => $this->new_price,
            'from' => $this->from,
            'to' => $this->to
        ];
    }
}
