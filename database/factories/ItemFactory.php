<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // Creates an order if one isn't provided
            'sku' => $this->faker->bothify('SKU#####'),
            'qty' => $this->faker->numberBetween(1, 100),
            'cost' => $this->faker->randomFloat(2, 0, 9999.99), // Assuming a cost between 0 and 9999.99
            // The timestamps are automatically handled by the factory
        ];
    }
}
