<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use App\Models\Offer;
use App\Models\Restaurant;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    protected function ownsMeal(User $user, Offer $offer): bool
    {
        return $user->id === $offer->meal->restaurant->user_id;

    }


    public function create(User $user, Restaurant $restaurant)
    {

        if (!$user->hasPermissionTo('offer.create')) {
            return Response::deny(__('general.have_permission'), 403);
        }
        return $user->id === $restaurant->user_id
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer)
    {
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Offer $offer)
    {
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Offer $offer)
    {
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function delete(User $user, Offer $offer)
    {
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

}
