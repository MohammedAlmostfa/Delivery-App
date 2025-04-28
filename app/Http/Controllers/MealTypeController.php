<?php

namespace App\Http\Controllers;

use App\Models\MealType;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Services\MealTypeService;
use App\Http\Resources\GroupedMealTypesResource;

class MealTypeController extends Controller
{
    protected $mealTypeService;

    /**
     * Inject MealTypeService dependency.
     *
     * @param MealTypeService $mealTypeService
     */
    public function __construct(MealTypeService $mealTypeService)
    {
        $this->mealTypeService = $mealTypeService;
    }

    /**
     * Display a listing of the meal types for a restaurant.
     */
    public function index(Restaurant $restaurant)
    {
        $result = $this->mealTypeService->getMealType($restaurant);

        return $result['status'] === 200
            ? self::success(new GroupedMealTypesResource($result['data'], ), $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

}
