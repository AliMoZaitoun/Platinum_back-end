<?php

namespace Database\Factories\Engineer;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        $baseLat = 25.276987;
        $baseLng = 51.520008;

        return [
            'check_in_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'check_out_time' => $this->faker->optional(0.8)->dateTimeBetween('now', '+8 hours'),
            'check_in_latitude' => $baseLat + $this->faker->randomFloat(6, -0.01, 0.01),
            'check_in_longitude' => $baseLng + $this->faker->randomFloat(6, -0.01, 0.01),
            'status' => $this->faker->randomElement(['present', 'late', 'absent']),
        ];
    }
}
