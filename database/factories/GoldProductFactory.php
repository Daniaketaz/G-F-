<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GoldSeeder>
 */
class GoldProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['product_id' => "\Closure", 'jewelry-types-id' => "int", 'jewelry-categories-id' => "int", 'description' => "string", 'weight' => "int", 'accessories price' => "int", 'formulation price' => "int", 'final price' => "int", 'views' => "int"])] public function definition()
    {
        return [
            'product_id' => function()
            {return Product::factory()->create()->id;},
            'jewelry-categories-id' => fake()->numberBetween(1, 4),
            'description' => fake()->text(),
            'weight' => fake()->randomNumber(3),
            'accessories_price' => fake()->randomNumber(3),
            'formulation_price' => fake()->randomNumber(3),
            'final_price' => fake()->randomNumber(3),
            'views' => 0,
            'name'=> fake()->text(30),

        ];
    }
}
