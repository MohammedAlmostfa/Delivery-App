<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RandomMeal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
         "id" => $this->id,
            "mealName" => $this->mealName,
            "price" => $this->price,
        'average_rating' => (float) $this->restaurant_rate_avg,
            "restaurant_name" => $this->restaurant->restaurant_name ?? null,
            "Meal_name" => $this->mealType->mealTypeName ?? null,
            'image' => $this->image->image_path && $this->image->image_name && $this->image->mime_type
                ? "{$this->image->image_path}/{$this->image->image_name}.{$this->image->mime_type}"
                : null,
        ];
    }
}
