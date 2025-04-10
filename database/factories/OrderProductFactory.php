<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 10);
        $unitPrice = $product->price ?? $this->faker->randomFloat(2, 1, 100);

        return [
            'order_id' => Order::inRandomOrder()->first()?->id ?? Order::factory()->create()->id,
            'product_id' => $product->id,
            'price' => round($unitPrice * $quantity, 2),
            'quantity' => $quantity,
        ];
    }
}
