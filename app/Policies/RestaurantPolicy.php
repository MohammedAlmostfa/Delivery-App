<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestaurantPolicy
{
    /**
     * Check if the user owns the restaurant or has an admin role.
     *
     * @param User $user The user attempting the action.
     * @param Restaurant $restaurant The restaurant being accessed.
     * @return bool Returns true if the user owns the restaurant or is an admin, false otherwise.
     */
    protected function ownsOrAdmin(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create a restaurant.
     *
     * @param User $user The user attempting to create a restaurant.
     * @return Response Authorization response allowing or denying the action.
     */
    public function create(User $user)
    {
        // Allow creation if the user has permission to create a restaurant.
        return $user->hasPermissionTo('restaurant.create')
            ? Response::allow()
            : Response::deny(__('general.have_permission'), 403);
    }

    /**
     * Determine whether the user can update the restaurant.
     *
     * @param User $user The user attempting to update the restaurant.
     * @param Restaurant $restaurant The restaurant to be updated.
     * @return Response Authorization response allowing or denying the action.
     */
    public function update(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('restaurant.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow update if the user owns the restaurant or is an admin.
        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param User $user The user attempting to delete the restaurant.
     * @param Restaurant $restaurant The restaurant to be deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('restaurant.forceDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow deletion if the user owns the restaurant or is an admin.
        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the restaurant.
     *
     * @param User $user The user attempting to permanently delete the restaurant.
     * @param Restaurant $restaurant The restaurant to be permanently deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function permanentDelete(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('restaurant.permanentDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow permanent deletion if the user owns the restaurant or is an admin.
        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the restaurant.
     *
     * @param User $user The user attempting to restore the restaurant.
     * @param Restaurant $restaurant The restaurant to be restored.
     * @return Response Authorization response allowing or denying the action.
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('restaurant.restore')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow restoration if the user owns the restaurant or is an admin.
        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can force delete the restaurant.
     *
     * @param User $user The user attempting to force delete the restaurant.
     * @param Restaurant $restaurant The restaurant to be force deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('restaurant.forceDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow force deletion if the user owns the restaurant or is an admin.
        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
}
