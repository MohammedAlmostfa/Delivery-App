<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "mealName" => $this->mealName,
            "price" => $this->price,
            "time_of_prepare" => $this->time_of_prepare,
            "restaurant_name" => $this->restaurant->restaurant_name ?? null,
            "Meal_name" => $this->mealType->mealTypeName ?? null,
            "meal_type" => $this->mealType->mealTypeType ?? null,
            'average_rating' => (float) $this->restaurant_rate_avg,
            'image' => $this->image->image_path && $this->image->image_name && $this->image->mime_type
                ? "{$this->image->image_path}/{$this->image->image_name}.{$this->image->mime_type}"
                : null,
        ];
    }
}
