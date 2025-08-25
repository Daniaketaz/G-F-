<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartController>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'session_id' => function()
            {return Session::factory()->create()->id;},
            'product_id' =>fake()->numberBetween(1,10),
            'price' => fake()->randomNumber(3),
            'quantity' => fake()->randomNumber(3),
        ];
    }
}
