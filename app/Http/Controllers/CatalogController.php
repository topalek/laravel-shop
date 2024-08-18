<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = Category::query()->select(['id', 'title', 'slug'])->has('products')->get();
        $products = Product::query()
            ->with('brand')
            ->select(['id', 'brand_id', 'title', 'slug', 'price', 'thumbnail', 'json_properties'])
            ->search()
            ->withCategory($category)
                           ->filtered()
                           ->sorted()
                           ->paginate(6)
        ;

        return view('catalog.index', compact('products', 'categories', 'category'));
    }
}
