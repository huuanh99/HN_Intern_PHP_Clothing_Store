<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'total' => $this->faker->numberBetween(100000, 200000),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
