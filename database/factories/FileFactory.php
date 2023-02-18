<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'test.txt',
            'path' => '/files/test.txt',
            'extension' => 'txt',
            'size' => $this->faker->numberBetween(),
            'hash' => $this->faker->text(25)
        ];
    }
}
