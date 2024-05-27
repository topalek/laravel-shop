<?php

namespace App\Http\Controllers;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_response()
    {
        $this->get(action([HomeController::class, 'index']))
             ->assertOk()
             ->assertSee('Наши преимущества')
             ->assertViewIs('index')
        ;
    }

    public function test_success_data()
    {
        CategoryFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting'      => 100
        ]);
        $category = CategoryFactory::new()->create([
            'on_home_page' => true,
            'sorting'      => 1
        ]);

        BrandFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting'      => 100
        ]);
        $brand = BrandFactory::new()->create([
            'on_home_page' => true,
            'sorting'      => 1
        ]);
        ProductFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting'      => 100
        ]);
        $product = ProductFactory::new()->create([
            'on_home_page' => true,
            'sorting'      => 1
        ]);
        $this->get(action([HomeController::class, 'index']))
             ->assertOk()
             ->assertViewHas('categories.0', $category)
             ->assertViewHas('brands.0', $brand)
             ->assertViewHas('products.0', $product)
        ;
    }
}
