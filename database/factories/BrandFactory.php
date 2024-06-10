<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model  = Brand::class;
    private   $brands = [
        'Apple',
        'Microsoft',
        'Samsung',
        'Google',
        'Sony',
        'Intel',
        'HP',
        'Philips',
        'Xiaomi',
        'Panasonic',
        'Canon',
        'LG Electronics',
        'Dell Technologies',
        'Lenovo',
        'Acer',
        'ASUS',
        'Toshiba',
        'NVIDIA',
        'Qualcomm',
        'Huawei',
    ];

    public function definition(): array
    {
        return [
            'title' => fake()->randomElement($this->brands),
            'thumbnail' => $this->faker->fixtureImage('brands', 'brands'),
            'on_home_page' => fake()->boolean(),
            'sorting'      => fake()->numberBetween(1, 100),
        ];
    }
}
