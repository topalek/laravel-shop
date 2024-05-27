<?php

namespace Database\Factories;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => fake()->words(3, true),
            'price' => fake()->numberBetween(10030, 100000),
            'brand_id'     => Brand::query()->inRandomOrder()->value('id'),
            'thumbnail'    => $this->faker->fixtureImage('products', 'images/products'),
            'on_home_page' => fake()->boolean(),
            'sorting'      => fake()->numberBetween(1, 100),
        ];
    }
}
