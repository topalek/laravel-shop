<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['optionValues.option']);
        $viewed = Product::query()->with('brand')->whereIn('id', session('viewed', []))->where('id', '!=', $product->id)->limit(4)->get();
        $options = $product->optionValues->keyValues();
        session()->put('viewed.' . $product->id, $product->id);
        return view('catalog.product.show', compact('product', 'options', 'viewed'));
    }
}
