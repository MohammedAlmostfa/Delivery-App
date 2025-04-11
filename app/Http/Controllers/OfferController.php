<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Services\OfferService;
use App\Http\Requests\OfferRequest\StoreOfferData;
use App\Http\Requests\OfferRequest\UpdateOfferData;
use App\Http\Resources\OfferResource;
use App\Models\Meal;

/**
 * Class OfferController
 *
 * Handles CRUD operations for offers, ensuring proper authorization
 * and business logic execution via the OfferService.
 */
class OfferController extends Controller
{
    /**
     * @var OfferService Service for offer-related operations.
     */
    protected $offerService;

    /**
     * Constructor to inject the OfferService dependency.
     *
     * @param OfferService $offerService The service layer handling business logic.
     */
    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * Display a listing of offers.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the offer data.
     */
    public function index()
    {
        // Fetch offers via service
        $result = $this->offerService->getOffer();

        // Return appropriate response based on service result
        return $result['status'] === 200
               ? self::paginated($result['data'], OfferResource::class, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Store a newly created offer.
     *
     * @param StoreOfferData $request Validated request data for storing an offer.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function store(StoreOfferData $request)
    {
        // Retrieve the meal and its restaurant
        $meal_id = $request->meal_id;
        $meal = Meal::with('restaurant')->findOrFail($meal_id);
        $restaurant = $meal->restaurant;

        // Ensure user has permission to create an offer for this restaurant
        Gate::authorize('createOffer', $restaurant);

        // Validate request data
        $validatedData = $request->validated();

        // Create offer via service layer
        $result = $this->offerService->createOffer($validatedData);

        // Return appropriate response based on service result
        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Update an existing offer's details.
     *
     * @param UpdateOfferData $request Validated request data for updating an offer.
     * @param Offer $offer The offer instance to be updated.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function update(UpdateOfferData $request, Offer $offer)
    {
        // Ensure user has permission to update the offer
        Gate::authorize('update', $offer);

        // Validate request data
        $validatedData = $request->validated();

        // Update offer via service layer
        $result = $this->offerService->updateOffer($validatedData, $offer);

        // Return appropriate response based on service result
        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Remove an offer from the system.
     *
     * @param Offer $offer The offer instance to be deleted.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function destroy(Offer $offer)
    {
        // Ensure user has permission to delete the offer
        Gate::authorize('destroy', $offer);

        // Delete offer via service layer
        $result = $this->offerService->deleteOffer($offer);

        // Return appropriate response based on service result
        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }
}
