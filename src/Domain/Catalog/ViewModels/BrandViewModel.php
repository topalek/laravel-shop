<?php

namespace Domain\Catalog\ViewModels;


use Domain\Catalog\Models\Brand;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function homePage()
    {
        return Brand::query()->homePage()->get();
    }
}
