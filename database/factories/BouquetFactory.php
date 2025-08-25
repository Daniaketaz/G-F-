<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bouquet>
 */
class BouquetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => function()
            {return Product::factory()->create()->id;},
            'price' => fake()->randomNumber(3),
            'numberOfSales' => fake()->randomNumber(3),
            'description' => fake()->text(),
        ];
    }
}
