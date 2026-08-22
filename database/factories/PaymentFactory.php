<?php

namespace Database\Factories\Finance;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 10000, 100000),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'payment_method' => $this->faker->randomElement(['cash', 'bank_transfer', 'check']),
            'payment_type' => $this->faker->randomElement(['down_payment', 'installment', 'final_payment']),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
