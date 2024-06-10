<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\ViewModels\CategoryViewModel;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('brand')->homePage()->get();
        $brands = Brand::query()->homePage()->get();
        $categories = CategoryViewModel::make()->homePage();
        return view('index', compact('products', 'brands', 'categories'));
    }
}
