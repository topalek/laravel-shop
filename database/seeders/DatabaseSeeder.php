<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\Property;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $categories = Category::factory(7)->create();
        $properties = Property::factory(10)->create();
        Option::factory(2)->create();
        Brand::factory(20)->create();
        $optionValues = OptionValue::factory(10)->create();
        Product::factory(20)
               ->hasAttached($optionValues)
               ->hasAttached($properties, function () {
                   return ['value' => fake('ru')->word()];
               })
               ->create()->each(function ($product) use ($categories) {
                $product->categories()->attach(
                    $categories->random(random_int(1, 3))->pluck('id')->toArray()
                );
            })
        ;
    }
}
