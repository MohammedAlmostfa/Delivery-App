<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Services\RestaurantService;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\RestaurantResource;
use App\Http\Requests\RestaurantRequest\StoreRestaurantData;
use App\Http\Requests\RestaurantRequest\UpdateRestaurantData; // Fixed the casing inconsistency

class RestaurantController extends Controller
{
    /**
     * @var RestaurantService
     */
    protected $restaurantservice;

    /**
     * Constructor to inject the RestaurantService dependency.
     *
     * @param RestaurantService $restaurantservice
     */
    public function __construct(RestaurantService $restaurantservice)
    {
        $this->restaurantservice = $restaurantservice;
    }

    /**
     * Display a listing of restaurants.
     *
     * Fetches all restaurants and provides a paginated response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->restaurantservice->getAllRestaurants();

        // Check the status of the service response
        return $result['status'] === 201
               ? self::paginated($result['data'], RestaurantResource::class, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Store a newly created restaurant.
     *
     * @param StoreRestaurantData $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRestaurantData $request)
    {
        Gate::authorize('create', Restaurant::class);

        $validatedData = $request->validated(); // Automatically validates incoming data
        $result = $this->restaurantservice->createRestaurant($validatedData);

        // Check the status of the service response
        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Display the specified restaurant's details.
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Restaurant $restaurant)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Restaurant fetched successfully.',
            'data' => new RestaurantResource($restaurant),
        ]);
    }

    /**
     * Update the specified restaurant's details.
     *
     * @param UpdateRestaurantData $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRestaurantData $request, Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);

        $validatedData = $request->validated(); // Automatically validates incoming data
        $result = $this->restaurantservice->updateRestaurant($restaurant, $validatedData);

        // Check the status of the service response
        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Remove the specified restaurant (soft delete).
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        Gate::authorize('forceDelete', $restaurant);

        $result = $this->restaurantservice->forceDeleteRestaurant($restaurant);

        // Check the status of the service response
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Permanently delete the specified restaurant from storage.
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function permanentDelete($id)
    {
        $restaurant=Restaurant::withTrashed()->findOrFail($id);
        Gate::authorize('permanentDelete', $restaurant);

        $result = $this->restaurantservice->permanentDeleteRestaurant($id);

        // Check the status of the service response
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }
}
