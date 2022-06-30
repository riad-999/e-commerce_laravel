<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'state' => ['en traitment', 'en route', 'livré'],
            'address' => $this->faker->address(),
            'wilaya' => $this->faker->word(),
            'shipment' => $this->faker->numberBetween(400, 1300),
            'number' => $this->faker->phoneNumber(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email()
        ];
    }
}