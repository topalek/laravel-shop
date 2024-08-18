<?php

namespace App\Jobs;

use Domain\Product\Models\Product;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductJsonProperties implements ShouldQueue, ShouldBeUnique
{
    use Queueable, InteractsWithQueue, Dispatchable, SerializesModels;

    public function __construct(public Product $product) {}

    public function handle(): void
    {
        $properties = $this->product->properties->keyValues();
        $this->product->updateQuietly(['json_properties' => $properties]);
    }

    public function uniqueId(): mixed
    {
        return $this->product->getKey();
    }
}
