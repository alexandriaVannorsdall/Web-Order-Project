<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** Test the index method on the OrderController
     *
     * @return void
     * */
    public function test_index_returns_all_orders(): void
    {
        $orders = Order::factory()->count(3)->create();

        $response = $this->getJson(route('orders.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($orders->toArray());
    }

    /** Test the store method on the OrderController
     *
     * @return void
     */
    public function test_store_creates_a_new_order_and_returns_it(): void
    {
        $orderData = [
            'reference' => Str::random(),
            'customer' => 'Test Customer',
            'email' => 'customer@example.com',
            'name' => 'Test Product'
        ];

        $response = $this->postJson(route('orders.store'), $orderData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('orders', $orderData);
        $response->assertJsonFragment($orderData);
    }

    /**
     * Test the show method on the OrderController.
     *
     * @return void
     */
    public function test_show_returns_order_as_json()
    {
        // Create a new order instance with given structure
        $order = Order::create([
            'id' => 44,
            'reference' => 'M7mgh9tRev',
            'customer' => 'Avis Gulgowski',
            'name' => 'Ab blanditiis dolorum et facilis.',
            'email' => 'vgislason@example.net',
            'created_at' => '2024-03-16T15:26:34.000000Z',
            'updated_at' => '2024-03-16T15:26:34.000000Z',
            // Other necessary attributes for the Order model
        ]);

        // Perform the HTTP GET request
        // Make sure to replace `['reference' => $order->reference]`
        // with `['order' => $order->id]` or the appropriate field and value.
        $response = $this->getJson(route('orders.show', ['order' => $order->id]));

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response has the correct data
        $response->assertJson([
            'id' => $order->id,
            'reference' => $order->reference,
            'customer' => $order->customer,
            'name' => $order->name,
            'email' => $order->email,
            'created_at' => $order->created_at->toJSON(),
            'updated_at' => $order->updated_at->toJSON(),
        ]);
    }


    // Could also write a test to test that it handles not found

    /** Test the update method on the OrderController
     *
     * @return void
     */
    public function test_update_modifies_the_specified_order(): void
    {
        $order = Order::factory()->create();
        $updateData = [
            'customer_name' => 'Updated Customer Name',
            'order_date' => now()->toDateString()
        ];

        $response = $this->putJson(route('orders.update', $order), $updateData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment($updateData);
        $this->assertDatabaseHas('orders', $updateData);
    }

    /** Test the destroy method on the OrderController
     *
     * @return void
     */
    public function test_deletes_the_specified_order_and_returns_no_content_status(): void
    {
        // Arrange: Create a new order in the database
        $order = Order::factory()->create();

        // Assert the order exists in the database before deletion
        $this->assertDatabaseHas('orders', ['id' => $order->id]);

        // Act: Send a delete request to destroy the order
        $response = $this->deleteJson(route('orders.destroy', $order));

        // Assert the response status is 204 No Content
        $response->assertStatus(204);

        // Assert the order does not exist in the database after deletion
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}

