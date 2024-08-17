<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('brand')->homePage()->get();
        $brands = BrandViewModel::make()->homePage();
        $categories = CategoryViewModel::make()->homePage();
        return view('index', compact('products', 'brands', 'categories'));
    }
}
