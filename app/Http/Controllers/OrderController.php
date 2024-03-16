<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Listing all orders
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    /**
     * Receive an order
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reference' => 'required|string|unique:orders',
            'customer' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = new Order($data);
        $order->save();

        return response()->json($order, 201); // 201 Created
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(null, 204); // 204 No Content
    }
}
