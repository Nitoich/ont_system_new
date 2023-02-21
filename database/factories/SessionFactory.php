<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => Str::random(128),
            'user_id' => User::factory(),
            'device_name' => 'TEST_GENERATED',
            'expire_date' => new \DateTime('now +1 month')
        ];
    }
}
