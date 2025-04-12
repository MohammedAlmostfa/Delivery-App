<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest\StoreOrderData;
use App\Http\Requests\OrderRequest\UpdateOrderData;

class OrderController extends Controller
{
    protected $orderservice;
    public function __construct(OrderService $orderservice)
    {
        $this->orderservice = $orderservice;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderData $request)
    {
        $validatecData = $request->validated();
        $result = $this->orderservice->creatOrder($validatecData);
        // Return success or error based on the service response
        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderData $request, Order $order)
    {
        $validatecData = $request->validated();
        $result = $this->orderservice->updateOrder($validatecData, $order);
        // Return success or error based on the service response
        return $result['status'] === 200
            ? self::success($result['data'] ?? null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

        $result = $this->orderservice->deleteOrder($order);
        // Return success or error based on the service response
        return $result['status'] === 200
            ? self::success(null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }
}
