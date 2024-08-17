<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory(7)->create();
        $this->call(PropertySeeder::class);
        $properties = Property::get();

        Option::factory(2)->create();
        Brand::factory(20)->create();
        $optionValues = OptionValue::factory(10)->create();
        Product::factory(20)
               ->hasAttached($optionValues)
               ->hasAttached($properties, function () {
                   return ['value' => fake('ru_RU')->word()];
               })
               ->create()->each(function ($product) use ($categories) {
                $product->categories()->attach(
                    $categories->random(random_int(1, 3))->pluck('id')->toArray()
                );
            })
        ;
    }
}
