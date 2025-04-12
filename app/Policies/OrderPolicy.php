<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Check if the user owns the order.
     *
     * @param User $user The user attempting the action.
     * @param Order $order The order being accessed.
     * @return bool Returns true if the user owns the order, false otherwise.
     */
    protected function ownsOrder(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Check if the order was created more than 5 minutes ago.
     *
     * @param Order $order The order being checked.
     * @return bool Returns true if the order is older than 5 minutes, false otherwise.
     */
    protected function checkTime(Order $order): bool
    {
        return $order->created_at->lte(now()->subMinutes(5));
    }

    /**
     * Determine if the user can update the order.
     *
     * @param User $user The user attempting to update the order.
     * @param Order $order The order to be updated.
     * @return Response Authorization response allowing or denying the action.
     */
    public function update(User $user, Order $order): Response
    {
        // Deny access if the user does not own the order
        if (!$this->ownsOrder($user, $order)) {
            return Response::deny(__('general.not_for_you'), 403);
        }

        // Deny access if the order is older than 5 minutes
        if ($this->checkTime($order)) {
            return Response::deny(__('general.time_out'), 403);
        }

        // Allow the update if all conditions are met
        return Response::allow();
    }

    /**
     * Determine if the user can delete the order.
     *
     * @param User $user The user attempting to delete the order.
     * @param Order $order The order to be deleted.
     * @return Response Authorization response allowing or denying the action.
     */
    public function delete(User $user, Order $order): Response
    {
        // Deny access if the user does not own the order
        if (!$this->ownsOrder($user, $order)) {
            return Response::deny(__('general.not_for_you'), 403);
        }

        // Deny access if the order is older than 5 minutes
        if ($this->checkTime($order)) {
            return Response::deny(__('general.time_out'), 403);
        }

        // Allow the deletion if all conditions are met
        return Response::allow();
    }
}
