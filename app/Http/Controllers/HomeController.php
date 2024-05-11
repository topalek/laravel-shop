<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->homePage()->get();
        $brands = Brand::query()->homePage()->get();
        $categories = Category::query()->homePage()->get();
        return view('index', compact('products', 'brands', 'categories'));
    }
}
