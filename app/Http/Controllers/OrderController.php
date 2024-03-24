<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Return a list of orders
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reference' => 'required|string|unique:orders',
            'customer' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        // Using new Order instance and save() instead of create()
        $order = new Order($data);
        $order->save();

        return response()->json($order, 201); // 201 Created
    }

    /**
     * Receive an order
     *
     * @param $reference
     * @return JsonResponse
     */
    public function show($reference): JsonResponse
    {
        // Retrieve the order by its reference field
        $order = Order::where('reference', $reference)->firstOrFail();

        // Return the found order as a JSON response with a 200 OK status
        return response()->json($order);
    }

    /**
     * Update an existing order
     *
     * @param Request $request
     * @param $reference
     * @return JsonResponse
     */
    public function update(Request $request, $reference): JsonResponse
    {
        // Find the order by reference
        $order = Order::where('reference', $reference)->firstOrFail();

        // Apply the updates to the order
        $order->update($request->all());

        // Return a successful response, such as:
        return response()->json(['message' => 'Order updated successfully'], 200);
    }

    /**
     * Delete and existing order by ID
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(null, 204); // 204 No Content
    }
}
