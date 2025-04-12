<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\OrderRequest\StoreOrderData;
use App\Http\Requests\OrderRequest\UpdateOrderData;

/**
 * Class OrderController
 *
 * Handles order-related actions such as creation, update, and deletion.
 */
class OrderController extends Controller
{
    protected $orderservice;

    /**
     * Constructor to inject OrderService dependency.
     *
     * @param OrderService $orderservice
     */
    public function __construct(OrderService $orderservice)
    {
        $this->orderservice = $orderservice;
    }

    /**
     * Show the form for creating a new resource.
     * This method is currently unused but can be implemented in the future.
     */
    public function create()
    {
        // Placeholder for a future order creation form
    }

    /**
     * Store a newly created order in the database.
     *
     * @param StoreOrderData $request Validated order data.
     * @return \Illuminate\Http\JsonResponse Success or error response.
     */
    public function store(StoreOrderData $request)
    {
        // Validate incoming request data
        $validatedData = $request->validated();

        // Call the service method to create the order
        $result = $this->orderservice->createOrder($validatedData);

        // Return response based on operation success or failure
        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Display a specific order.
     * This method is currently unused but can be implemented for order details.
     *
     * @param Order $order The order instance.
     */
    public function show(Order $order)
    {
        // Placeholder for showing order details
    }

    /**
     * Update the specified order in the database.
     *
     * @param UpdateOrderData $request Validated update data.
     * @param Order $order The order instance to update.
     * @return \Illuminate\Http\JsonResponse Success or error response.
     */
    public function update(UpdateOrderData $request, Order $order)
    {
        Gate::authorize('update', $order);

        // Validate incoming request data
        $validatedData = $request->validated();

        // Call the service method to update the order
        $result = $this->orderservice->updateOrder($validatedData, $order);

        // Return response based on operation success or failure
        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param Order $order The order instance to delete.
     * @return \Illuminate\Http\JsonResponse Success or error response.
     */
    public function destroy(Order $order)
    {
        Gate::authorize('delete', $order);


        // Call the service method to delete the order
        $result = $this->orderservice->deleteOrder($order);

        // Return response based on operation success or failure
        return $result['status'] === 200
            ? self::success(null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }
}
