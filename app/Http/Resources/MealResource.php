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
            "name" => $this->mealType->mealTypeName ?? null,
            "type" => $this->mealType->mealTypeType ?? null,
        ];
    }
}
