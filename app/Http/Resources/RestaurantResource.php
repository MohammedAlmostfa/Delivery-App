<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
              'restaurant_id' => $this->id,
              'restaurant_name' => $this->restaurant_name,
              'average_rating' => (float) $this->restaurant_rate_avg,
        ];
    }
}
