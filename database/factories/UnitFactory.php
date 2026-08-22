<?php

namespace Database\Factories;

use App\Models\RealEstate\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'building_id' => Building::factory(),
            'name' => [
                'ar' => 'وحدة سكنية ' . $this->faker->unique()->numerify('A-###'),
                'en' => 'Residential Unit ' . $this->faker->unique()->numerify('A-###'),
            ],
            'description' => [
                'ar' => 'وحدة سكنية فاخرة بإطلالة مميزة وتشطيب سوبر ديلوكس.',
                'en' => 'Luxury residential unit with a premium view and super deluxe finishing.',
            ],
            'price' => $this->faker->randomFloat(2, 500000, 5000000), // السعر بين نصف مليون و5 مليون
            'area' => $this->faker->randomFloat(2, 80, 400),
            'rooms' => $this->faker->numberBetween(2, 6),
            'status' => $this->faker->randomElement(['available', 'sold', 'reserved']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
