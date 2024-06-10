<?php

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_generate_thumbnail()
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');
        config()->set('thumbnail', ['allowed_sizes' => [$size]]);

        $product = ProductFactory::new()->create();
        $response = $this->get($product->makeThumbnail($size, $method));
        $response->assertOk();
        $storage->assertExists("products/$method/$size/" . File::basename($product->thumbnail));
    }
}
