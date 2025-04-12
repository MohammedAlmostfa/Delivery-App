<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use App\Models\Offer;
use App\Models\Restaurant;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    /**
     * Check if the user owns the meal associated with the offer.
     *
     * @param User $user The user attempting the action.
     * @param Offer $offer The offer being accessed.
     * @return bool Returns true if the user owns the meal related to the offer, false otherwise.
     */
    protected function ownsMeal(User $user, Offer $offer): bool
    {
        return $user->id === $offer->meal->restaurant->user_id;
    }

    /**
     * Determine whether the user can create an offer for the restaurant.
     *
     * @param User $user The user attempting to create an offer.
     * @param Restaurant $restaurant The restaurant related to the offer.
     * @return Response Authorization response allowing or denying the action.
     */
    public function create(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('offer.create')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow creation only if the user owns the restaurant.
        return $user->id === $restaurant->user_id
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can update the offer.
     *
     * @param User $user The user attempting to update the offer.
     * @param Offer $offer The offer to be updated.
     * @return Response Authorization response allowing or denying the action.
     */
    public function update(User $user, Offer $offer)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow update only if the user owns the associated meal.
        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the offer.
     *
     * @param User $user The user attempting to delete the offer.
     * @param Offer $offer The offer to be deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function destroy(User $user, Offer $offer)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow deletion only if the user owns the associated meal.
        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the offer.
     *
     * @param User $user The user attempting to restore the offer.
     * @param Offer $offer The offer to be restored.
     * @return Response Authorization response allowing or denying the action.
     */
    public function restore(User $user, Offer $offer)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow restoration only if the user owns the associated meal.
        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the offer.
     *
     * @param User $user The user attempting to permanently delete the offer.
     * @param Offer $offer The offer to be permanently deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function delete(User $user, Offer $offer)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('offer.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow deletion only if the user owns the associated meal.
        return $this->ownsMeal($user, $offer)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
}
