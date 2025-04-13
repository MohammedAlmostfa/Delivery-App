<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RatingRequest\StoreRatingData;
use App\Http\Requests\RatingRequest\UpdateRatingData;

class RatingController extends Controller
{
    protected $RatingService;

    public function __construct(RatingService $RatingService)
    {
        $this->RatingService = $RatingService;
    }

    public function store(StoreRatingData $request)
    {
        $validatedData = $request->validated();

        $result = $this->RatingService->createRating($validatedData);

        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    public function update(UpdateRatingData $request, Rating $rating)
    {
        // Gate::authorize('update', $rating); // إذا عندك صلاحيات

        $validatedData = $request->validated();

        $result = $this->RatingService->updateRating($validatedData, $rating);

        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    public function destroy(Rating $rating)
    {
        // Gate::authorize('delete', $rating); // إذا عندك صلاحيات

        $result = $this->RatingService->deleteRating($rating);

        return $result['status'] === 200
            ? self::success(null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }
}
