<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrderService
 *
 * Handles order creation, updating, and deletion.
 */
class OrderService
{
    /**
     * Create a new order.
     *
     * @param array $data Order details including restaurant_id, meals, and location.
     * @return array Response with status and order data.
     */
    public function createOrder(array $data)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Create the order in the database
            $order = Order::create([
                'restaurant_id' => $data['restaurant_id'],
                'user_id' => $user->id,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'payment_method' => $data['payment_method'], // Ensure correct column naming
            ]);

            // Attach meals to the order with quantity information
            foreach ($data['meals'] as $meal) {
                $order->meals()->attach($meal['meal_id'], ['quantity' => $meal['quantity']]);
            }

            // Return success response
            return [
                'status' => 200,
                'message' => __('order.created_successfully'),
                'order' => $order
            ];

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error creating order: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Update an existing order.
     *
     * @param array $data Updated order details.
     * @param Order $order The order to update.
     * @return array Response with status and updated order data.
     */
    public function updateOrder(array $data, Order $order)
    {
        try {
            // Update order details with new values, or keep old values if none are provided
            $order->update([
                'latitude' => $data['latitude'] ?? $order->latitude,
                'longitude' => $data['longitude'] ?? $order->longitude,
                'payment_method' => $data['payment_method'] ?? $order->payment_method,
            ]);

            // If meals are provided, update pivot table with new quantities
            if (isset($data["meals"]) && !empty($data['meals'])) {
                $syncData = [];
                foreach ($data['meals'] as $meal) {
                    $syncData[$meal['meal_id']] = ['quantity' => $meal['quantity']];
                }
                $order->meals()->sync($syncData);
            }

            // Return success response with fresh order data
            return [
                'status' => 200,
                'message' => __('general.update_success'),
                'data' => $order->fresh() // Ensures latest data with relationships
            ];

        } catch (\Exception $e) {
            // Rollback changes in case of failure
            DB::rollBack();
            Log::error("Error updating order: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    /**
     * Delete an order.
     *
     * @param Order $order The order to be deleted.
     * @return array Response with deletion status.
     */
    public function deleteOrder(Order $order)
    {
        try {
            // Delete the order from the database
            $order->delete();

            return [
                'status' => 200,
                'message' => __('general.delete_success'),
            ];

        } catch (\Exception $e) {
            // Log error with order ID for tracking purposes
            Log::error("Error deleting order ID {$order->id}: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.delete_error'),
            ];
        }
    }
}
