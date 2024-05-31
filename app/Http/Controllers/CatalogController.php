<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;

class CatalogController extends Controller
{
    public function __invoke(?Category $category = null)
    {
        $brands = Brand::query()->has('products')->distinct()->get();
        $categories = Category::query()->has('products')->get();
        $products = Product::query()->paginate(6);
        return view('catalog.index', compact('products', 'brands', 'categories', 'category'));
    }
}
