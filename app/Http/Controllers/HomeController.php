<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        //        Product::query()->first()->makeThumbnail('345x320');
        $products = Product::query()->homePage()->get();
        $brands = Brand::query()->homePage()->get();
        $categories = Category::query()->homePage()->get();
        return view('index', compact('products', 'brands', 'categories'));
    }
}
