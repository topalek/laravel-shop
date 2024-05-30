<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
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
        Brand::factory(20)->create();
        Product::factory(20)->create()->each(function ($product) use ($categories) {
            $product->categories()->attach(
                $categories->random(random_int(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
