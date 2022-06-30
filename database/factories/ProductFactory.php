<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(1000, 5000);
        $promo = $price - $price * random_int(1, 5) * 10 / 100;
        return [
            'name' => $this->faker->words(random_int(1, 4)),
            'price' => $price,
            'promo' =>  $promo,
        ];
    }
}