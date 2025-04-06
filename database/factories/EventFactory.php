<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $end = (clone $start)->modify('+2 hours');

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
