<?php

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_response()
    {
        $product = ProductFactory::new()->create();
        $this->get(action([ProductController::class, 'show'], $product))
             ->assertOk()
             ->assertSee('Описание')
             ->assertViewIs('catalog.product.show')
        ;
    }

}
