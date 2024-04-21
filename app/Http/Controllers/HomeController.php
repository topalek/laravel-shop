<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->limit(4)->get();
        $brands = Brand::query()->limit(6)->get();
        return view('index', compact('products', 'brands'));
    }
}
