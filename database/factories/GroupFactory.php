<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->bothify('b-????-##'),
            'faculty' => $this->faker->sentence(),
            'url' => $this->faker->randomNumber(5)
        ];
    }

}