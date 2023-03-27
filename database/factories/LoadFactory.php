<?php

namespace Database\Factories;

use App\Models\Discipline;
use App\Models\Group;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'discipline_id' => Discipline::factory(),
            'semester_id' => Semester::factory(),
            'type' => $this->faker->randomElement(['vacancy', 'load']),
            'characteristic' => $this->faker->randomElement(['budget', 'commerce']),
            'hours' => $this->faker->numberBetween(0, 10)
        ];
    }
}
