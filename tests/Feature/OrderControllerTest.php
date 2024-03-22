<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    // Use RefreshDatabase to reset the database between tests
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_lists_all_orders(): void
    {
        // Arrange: Create a few orders in the database
        $orders = Order::factory()->count(3)->create();

        // Act: Make a get request to the index route
        $response = $this->getJson(route('orders.index'));

        // Assert: Verify that we receive a 200 OK response and that the response contains all orders
        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJson($orders->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function it_stores_a_new_order(): void
    {
        // Arrange: Prepare order data
        $orderData = [
            'reference' => 'REF123',
            'customer'  => 'John Doe',
            'email'     => 'john@example.com',
            'name'      => 'Order Name'
        ];

        // Act: Submit post request to store a new order
        $response = $this->postJson(route('orders.store'), $orderData);

        // Assert: Verify that the order was created and the response is correct
        $response->assertCreated();
        $this->assertDatabaseHas('orders', ['reference' => 'REF123']);
        $response->assertJsonFragment([
            'customer' => 'John Doe',
            'email'    => 'john@example.com',
            'name'     => 'Order Name',
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function it_shows_an_order(): void
    {
        // Arrange: Create an order
        $order = Order::factory()->create();

        // Act: Make a get request to show the order
        $response = $this->getJson(route('orders.show', ['order' => $order->reference]));

        // Assert: Verify we received a 200 OK response with the order data
        $response->assertOk();
        $response->assertJson($order->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function it_updates_an_existing_order(): void
    {
        // Arrange: Create an order with a unique reference
        $order = Order::factory()->create([
            'reference' => 'original-ref-123'
        ]);
        $updateData = ['customer' => 'Updated Customer Name', 'reference' => 'updated-ref-456'];

        // Act: Submit put request to update the order
        $response = $this->putJson(route('orders.update', $order), $updateData);

        // Assert: Check response and if order was updated in the database
        $response->assertOk();
        $order->refresh(); // Refresh the model to get updated data

        // Ensure the 'customer' field updated correctly
        $this->assertEquals($updateData['customer'], $order->customer);

        // No need to check dates now, we are verifying the 'reference' field instead
        $this->assertEquals($updateData['reference'], $order->reference);
    }

    /**
     * @test
     * @return void
     */
    public function it_deletes_an_order(): void
    {
        // Arrange: Create an order
        $order = Order::factory()->create();

        // Act: Submit delete request to delete the order
        $response = $this->deleteJson(route('orders.destroy', $order));

        // Assert: Verify the response status and that the order was deleted from the database
        $response->assertNoContent();
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
