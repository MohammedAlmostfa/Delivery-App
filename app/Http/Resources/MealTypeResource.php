<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mealTypeName' => $this->mealTypeName,
        ];
    }
}
