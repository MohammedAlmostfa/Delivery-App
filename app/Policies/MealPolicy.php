<?php

namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Auth\Access\Response;

class MealPolicy
{
    /**
     * Check if the user owns the meal associated with a restaurant.
     *
     * @param User $user The user attempting the action.
     * @param Meal $meal The meal being accessed.
     * @return bool Returns true if the user owns the meal related to the restaurant, false otherwise.
     */
    protected function ownsMeal(User $user, Meal $meal): bool
    {
        return $user->id == $meal->restaurant->user_id;
    }

    /**
     * Determine whether the user can create a meal for the restaurant.
     *
     * @param User $user The user attempting to create a meal.
     * @param Restaurant $restaurant The restaurant where the meal will be created.
     * @return Response Authorization response allowing or denying the action.
     */
    public function create(User $user, Restaurant $restaurant)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.create')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow creation only if the user owns the restaurant.
        return $user->id === $restaurant->user_id
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can update the meal.
     *
     * @param User $user The user attempting to update the meal.
     * @param Meal $meal The meal to be updated.
     * @return Response Authorization response allowing or denying the action.
     */
    public function update(User $user, Meal $meal)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow update only if the user owns the associated meal.
        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can delete the meal.
     *
     * @param User $user The user attempting to delete the meal.
     * @param Meal $meal The meal to be deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function delete(User $user, Meal $meal)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow deletion only if the user owns the associated meal.
        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can restore the meal.
     *
     * @param User $user The user attempting to restore the meal.
     * @param Meal $meal The meal to be restored.
     * @return Response Authorization response allowing or denying the action.
     */
    public function restore(User $user, Meal $meal)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow restoration only if the user owns the associated meal.
        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the meal.
     *
     * @param User $user The user attempting to permanently delete the meal.
     * @param Meal $meal The meal to be permanently deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function forceDelete(User $user, Meal $meal)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow permanent deletion only if the user owns the associated meal.
        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }

    /**
     * Determine whether the user can permanently delete the meal (alternative method).
     *
     * @param User $user The user attempting to permanently delete the meal.
     * @param Meal $meal The meal to be permanently deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function permanentDelete(User $user, Meal $meal)
    {
        // Deny access if the user does not have the required permission.
        if (!$user->hasPermissionTo('meal.update')) {
            return Response::deny(__('general.have_permission'), 403);
        }

        // Allow permanent deletion only if the user owns the associated meal.
        return $this->ownsMeal($user, $meal)
            ? Response::allow()
            : Response::deny(__('general.not_for_you'), 403);
    }
}
