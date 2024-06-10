<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = Category::query()->select(['id', 'title', 'slug'])->has('products')->get();
        $products = Product::query()
            ->with('brand')
                           ->select(['id', 'brand_id', 'title', 'slug', 'price', 'thumbnail'])
            ->when(request('s'), function (Builder $q) {
                $q->whereFullText(['title', 'text'], request('s'));
            })
                           ->when($category->exists, function (Builder $q) use ($category) {
                               $q->whereRelation('categories', 'categories.id', '=', $category->id);
                           })
                           ->filtered()
                           ->sorted()
                           ->paginate(6)
        ;

        return view('catalog.index', compact('products', 'categories', 'category'));
    }
}
