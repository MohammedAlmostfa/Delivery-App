<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function creatOrder($data)
    {
        try {


            $user=Auth::user();
            // Correct method name is 'create' not 'creat'
            $order = Order::create([
                'restaurant_id' => $data['restaurant_id'],
                'user_id' => $user->id,
                'latitude' => $data['latitude'] ,
                'longitude' => $data['longitude'],
                'payment_method' => $data['payment_method'], // Typically lowercase for column names
            ]);

            $meals = $data['meals'];
            foreach ($meals as $meal) {
                // Correct syntax for attaching meals with pivot data
                $order->meals()->attach($meal['meal_id'], ['quantity' => $meal['quantity']]);
            }

            // You should return something on success
            return [
                'status' => 200,
                'message' => __('order.created_successfully'),
                'order' => $order
            ];

        } catch (\Exception $e) {


            Log::error("Error creating order: " . $e->getMessage());
            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }

    public function updateOrder($data, Order $order)
    {
        try {


            $order->update([
                'latitude' => $data['latitude'] ?? $order->latitude,
                'longitude' => $data['longitude'] ?? $order->longitude,
                'payment_method' => $data['payment_method'] ?? $order->payment_method,
            ]);

            if(isset($data["meals"]) && !empty($data['meals'])) {
                $syncData = [];
                foreach ($data['meals'] as $meal) {
                    $syncData[$meal['meal_id']] = ['quantity' => $meal['quantity']];
                }
                $order->meals()->sync($syncData);
            }


            return [
                'status' => 200,
                'message' => __('general.update_success'),
                'data' => $order->fresh() // Return fresh data with relationships
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating order: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.general_error'),
            ];
        }
    }


    public function deleteOrder(Order $order)
    {
        try {

            // Delete the order
            $order->delete();
            return [
                'status' => 200,
                'message' => __('general.delete_success'),
            ];

        } catch (\Exception $e) {

            Log::error("Error deleting order ID {$order->id}: " . $e->getMessage());

            return [
                'status' => 500,
                'message' => __('general.delete_error'),
            ];
        }
    }

}
