<?php

namespace Domain\Catalog\ViewModels;


use Cache;
use Domain\Catalog\Models\Category;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function homePage()
    {
        return Cache::rememberForever('category_home_page', function () {
            return Category::query()->homePage()->get();
        });
    }
}
