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
     * @param Order $order
     * @return JsonResponse
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'customer_name' => 'required|max:255',
            'order_date' => 'required|date',
            // Add other fields and validation rules as needed
        ]);

        try {
            // Update the order with validated data
            $order->update($validatedData);

            // Return the updated order with a 200 OK status code
            return response()->json($order);
        } catch (ValidationException $e) {
            // Handle the exception if validation fails
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle any other exception
            return response()->json([
                'message' => 'Error updating the order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete and existing order
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