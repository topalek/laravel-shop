<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()->limit(3)->get();
        return view('index', compact('products'));
    }
}
