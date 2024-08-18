<?php

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PriceFilter extends AbstractFilter
{
    public function title(): string
    {
        return "Цена";
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            $query->whereBetween('price', [
                $this->requestValue('from', 0) * 100,
                $this->requestValue('to', 10000) * 100,
            ]);
        });
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to'   => 10000,
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
