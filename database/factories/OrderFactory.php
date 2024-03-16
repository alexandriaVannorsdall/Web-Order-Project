<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => Str::random(10),
            'customer' => $this->faker->name,
            'name' => $this->faker->sentence,
            'email' => $this->faker->unique()->safeEmail,
            // The timestamps are automatically handled by the factory
        ];
    }
}
