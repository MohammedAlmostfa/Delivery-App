<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestaurantPolicy
{
    /**
     * Helper method to check if the user owns the restaurant or is an admin.
     */
    protected function ownsOrAdmin(User $user, Restaurant $restaurant): bool
    {
        return $user->id === $restaurant->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create a restaurant.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('restaurant.create')
            ? Response::allow()
            : Response::deny(__('general.have_permission'), 403);
    }

    /**
     * Determine whether the user can update the restaurant.
     */
    public function update(User $user, Restaurant $restaurant)
    {
        if (!$user->hasPermissionTo('restaurant.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the restaurant.
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        if (!$user->hasPermissionTo('restaurant.forceDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the restaurant.
     */
    public function permanentDelete(User $user, Restaurant $restaurant)
    {
        if (!$user->hasPermissionTo('restaurant.permanentDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the restaurant.
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        if (!$user->hasPermissionTo('restaurant.restore')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can force delete the restaurant.
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        if (!$user->hasPermissionTo('restaurant.forceDelete')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsOrAdmin($user, $restaurant)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
}
