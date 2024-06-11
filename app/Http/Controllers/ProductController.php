<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['optionValues.option']);
        $viewed = Product::query()->with('brand')->whereIn('id', session('viewed', []))->limit(4)->get();
        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });
        session()->put('viewed.' . $product->id, $product->id);
        return view('catalog.product.show', compact('product', 'options', 'viewed'));
    }
}
