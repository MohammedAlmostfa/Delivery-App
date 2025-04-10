<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Services\OfferService;
use App\Http\Requests\OfferRequest\StoreOfferData;
use App\Http\Requests\OfferRequest\UpdateOfferData;
use App\Models\Meal;

class OfferController extends Controller
{
    /**
     * @var OfferService
     */
    protected $offerService;

    /**
     * Constructor to inject the OfferService dependency.
     *
     * @param OfferService $offerService
     */
    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * Store a newly created offer.
     *
     * @param StoreOfferData $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOfferData $request)
    {
        $meal_id=$request->meal_id;
        $meal = Meal::with('restaurant')->findOrFail($meal_id);
        $restaurant = $meal->restaurant;
        Gate::authorize('createOffer', $restaurant);

        $validatedData = $request->validated();
        $result = $this->offerService->createOffer($validatedData);

        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Update the specified offer's details.
     *
     * @param UpdateOfferData $request
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOfferData $request, Offer $offer)
    {
        Gate::authorize('update', $offer);

        $validatedData = $request->validated();
        $result = $this->offerService->updateOffer($validatedData, $offer);

        return $result['status'] === 200
               ? self::success($result['data'], $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Remove the specified offer.
     *
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Offer $offer)
    {
        Gate::authorize('destroy', $offer);

        $result = $this->offerService->deleteOffer($offer);

        return $result['status'] === 200
               ? self::success(null, $result['message'], $result['status'])
               : self::error(null, $result['message'], $result['status']);
    }
}
