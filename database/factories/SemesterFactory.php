<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_start' => $this->faker->date('Y-m-d'),
            'date_end' => $this->faker->date('Y-m-d')
        ];
    }
}
