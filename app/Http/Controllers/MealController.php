<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use App\Services\MealService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\mealrequest\StoreMealData;
use App\Http\Requests\mealrequest\UpdateMealData;
use App\Http\Resources\MealResource;
use App\Http\Resources\RandomMeal;

class MealController extends Controller
{
    protected $mealservice;

    /**
     * Inject MealService dependency.
     *
     * This constructor accepts the MealService instance and binds it to the controller.
     *
     * @param MealService $mealservice
     */
    public function __construct(MealService $mealservice)
    {
        $this->mealservice = $mealservice;
    }

    /**
     * Display a listing of meals.
     *
     * This method will fetch and display all meals from the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMeal(Restaurant $restaurant)
    {
        $result = $this->mealservice->getMeal($restaurant);
        // Return success or error based on the service response
        return $result['status'] === 200
                 ? self::paginated($result['data'], MealResource::class, $result['message'], $result['status'])
                 : self::error(null, $result['message'], $result['status']);
    }
    public function getRandoumMeal()
    {
        $result = $this->mealservice->getRandomMeal();

        return $result['status'] === 200
                ? self::success(new RandomMeal($result['data'])?? null, $result['message'], $result['status'])
                : self::error(null, $result['message'], $result['status']);
    }
    /**
     * Store a new meal in the database.
     *
     * Authorizes the user and validates the incoming data before passing it to the MealService.
     *
     * @param StoreMealData $request Validated request data.
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMealData $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        Gate::authorize('createMeal', $restaurant);
        $validatedData = $request->validated(); // Validate incoming request data
        $result = $this->mealservice->createMeal($validatedData); // Call MealService to create meal

        // Return success or error based on the service response
        return $result['status'] === 200
               ? self::success($result['data'] ?? null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Display the details of a specific meal.
     *
     * Fetches and returns the details of a specific meal from the database.
     *
     * @param Meal $meal The meal to display.
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        // Logic to display the specified meal
    }

    /**
     * Update an existing meal in the database.
     *
     * Validates incoming data and calls the MealService to update the meal.
     *
     * @param UpdateMealData $request Validated request data.
     * @param Meal $meal The meal to be updated.
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMealData $request, Meal $meal)
    {
        Gate::authorize('update', $meal); // Authorization for updating a meal

        $validatedData = $request->validated(); // Validate incoming request data

        $result = $this->mealservice->updateMeal($validatedData, $meal); // Call MealService to update meal

        // Return success or error based on the service response
        return $result['status'] === 200
               ? self::success($result['data'] ?? null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Soft delete a meal from the database.
     *
     * Authorizes the user and calls MealService to perform the soft delete.
     *
     * @param Meal $meal The meal to be deleted.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        Gate::authorize('delete', $meal); // Authorization for deleting a meal

        $result = $this->mealservice->forcedeleteMeal($meal); // Call MealService to delete meal

        // Return success or error based on the service response
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Permanently delete a meal from the database.
     *
     * Fetches the soft-deleted meal and calls MealService to permanently delete it.
     *
     * @param int $id The ID of the meal to permanently delete.
     * @return \Illuminate\Http\Response
     */
    public function permanentDelete($id)
    {
        $meal = Meal::withTrashed()->findOrFail($id); // Fetch meal including soft-deleted ones

        Gate::authorize('permanentDelete', $meal); // Authorization for permanent delete

        $result = $this->mealservice->permanentDeleteMeal($meal); // Call MealService to permanently delete meal

        // Return success or error based on the service response
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Restore a soft-deleted meal.
     *
     * Fetches the soft-deleted meal and calls MealService to restore it.
     *
     * @param int $id The ID of the meal to restore.
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $meal = Meal::withTrashed()->findOrFail($id); // Fetch meal including soft-deleted ones

        Gate::authorize('restore', $meal); // Authorization for restoring a meal

        $result = $this->mealservice->restoreMeal($meal); // Call MealService to restore meal

        // Return success or error based on the service response
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }
}
