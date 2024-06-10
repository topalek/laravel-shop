<?php

namespace Domain\Catalog\Filters;

class FilterManager
{
    public function __construct(private array $items = []) {}

    public function registerFilters(array $items): void
    {
        $this->items = array_merge($this->items, $items);
    }

    public function items(): array
    {
        return $this->items;
    }
}
