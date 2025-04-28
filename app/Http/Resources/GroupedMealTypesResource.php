<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupedMealTypesResource extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->groupBy(function ($item) {
            return $item->mealTypeType;
        })->map(function ($group, $mealType) {
            return [
                'mealType' => $mealType,
                'mealTypes' => MealTypeResource::collection($group),
            ];
        })->values();
    }
}
