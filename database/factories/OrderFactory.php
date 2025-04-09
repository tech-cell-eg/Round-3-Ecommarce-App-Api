<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_no' => 'ORD-' . strtoupper(Str::random(10)),
            'total' => (float) number_format($this->faker->randomFloat(2, 1, 100), 2, '.', ''),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'user_id' => User::inRandomOrder()->first()?->id ?? 1
        ];
    }
}
