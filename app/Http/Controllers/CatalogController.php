<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $brands = Brand::query()->select(['id', 'title'])->has('products')->distinct()->get();
        $categories = Category::query()->select(['id', 'title', 'slug'])->has('products')->get();
        $products = Product::query()
                           ->select(['id', 'brand_id', 'title', 'slug', 'price', 'thumbnail'])
                           ->with(['brand'])
                           ->when($category->exists, function (Builder $q) use ($category) {
                               $q->whereRelation('categories', 'categories.id', '=', $category->id);
                           })
                           ->filtered()
                           ->sorted()
                           ->paginate(6)
        ;
        return view('catalog.index', compact('products', 'brands', 'categories', 'category'));
    }
}
