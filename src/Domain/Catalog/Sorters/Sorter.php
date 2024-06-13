<?php

namespace Domain\Catalog\Sorters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;

class Sorter
{
    public const SORT_KEY = 'sort';

    public function __construct(protected array $columns = []) {}

    public function run(Builder $query): Builder
    {
        $sortData = $this->sortData();
        $query->when($sortData->contains($this->columns()), function (Builder $q) use ($sortData) {
            $q->orderBy(
                (string)$sortData->remove('-'),
                $sortData->contains('-') ? 'desc' : 'asc'
            );
        });
    }

    private function sortData(): Stringable
    {
        return str(request($this->key()));
    }

    public function key(): string
    {
        return self::SORT_KEY;
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function isActive(string $column, $direction = 'asc'): bool
    {
        $column = trim('-', $column);

        if (strtolower($direction) === 'desc') {
            $column = '-' . $column;
        }

        return request($this->key()) === $column;
    }

}
