<?php

namespace Database\Factories\Legal;

use App\Models\User;
use App\Models\RealEstate\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = $this->faker->randomFloat(2, 500000, 2000000);
        $downPayment = $unitPrice * 0.20; // دفعة أولى 20%

        return [
            'client_id' => User::factory(), // سيتم تحديدها بالـ Seeder
            'unit_id' => Unit::factory(),
            'total_price' => $unitPrice,
            'down_payment_amount' => $downPayment,
            'currency' => 'QAR',
            'status' => $this->faker->randomElement(['draft', 'pending_approval', 'active', 'completed']),
            'signed_at' => $this->faker->optional(0.7)->date(),
        ];
    }
}
