<?php

namespace Jobs;


use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductJsonPropertyTest extends TestCase
{
    public function test_creates_json_props()
    {
        $queue = Queue::getFacadeRoot();
        Queue::fake([ProductJsonProperties::class]);
        $props = PropertyFactory::new()
                                ->count(10)
                                ->create()
        ;
        $product = ProductFactory::new()
                                 ->hasAttached($props, function () {
                                     return ['value' => fake()->word];
                                 })
                                 ->create()
        ;

        $this->assertEmpty($product->json_properties);
        Queue::swap($queue);
        ProductJsonProperties::dispatchSync($product);
        $product->refresh();
        $this->assertNotEmpty($product->json_properties);
    }

}
