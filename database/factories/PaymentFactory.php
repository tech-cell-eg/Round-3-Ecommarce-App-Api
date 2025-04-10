<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first() ?? Order::factory()->create();
        return [
            'order_id' => $order->id,
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'paid_amount' => $this->faker->randomFloat(2, 0, $order->total),
            'deposit_amount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
