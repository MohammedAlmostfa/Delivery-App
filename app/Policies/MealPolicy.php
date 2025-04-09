<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\Response;

class MealPolicy
{
    /**
     * Helper method to check if the user owns the meal.
     */
    protected function ownsMeal(User $user, Meal $meal): bool
    {
        return $user->id == $meal->restaurant->user_id;
    }



    public function create(User $user, Restaurant $restaurant)
    {

        if (!$user->hasPermissionTo('meal.create')) {
            return Response::deny(__('general.have_permission'), 403);
        }
        return $user->id === $restaurant->user_id
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Meal $meal)
    {
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Meal $meal)
    {
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Meal $meal)
    {
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Meal $meal)
    {
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
    public function permanentDelete(User $user, Meal $meal)
    {
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
}
