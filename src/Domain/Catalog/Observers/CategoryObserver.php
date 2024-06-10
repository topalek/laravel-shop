<?php

namespace Domain\Catalog\Observers;

use Cache;
use Domain\Catalog\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function updated(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function deleted(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function restored(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function forceDeleted(Category $category): void
    {
        Cache::forget('category_home_page');
    }
}
