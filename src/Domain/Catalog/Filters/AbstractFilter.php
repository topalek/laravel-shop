<?php

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    abstract public function title(): string;

    abstract public function values(): array;

    public function requestValue(string|int $index = null, mixed $default = null): mixed
    {
        return request(
            'filters.' . $this->key() . ($index ? ".$index" : ''),
            $default
        );
    }

    abstract public function key(): string;

    public function id(string|int $index = null): string
    {
        return str($this->name($index))->slug("_")->value();
    }

    public function name(string|int $index = null): string
    {
        return str($this->key())
            ->wrap('[', ']')
            ->prepend('filters')
            ->when($index, fn($str) => $str->append("[$index]"))
            ->value()
        ;
    }

    public function __toString(): string
    {
        return view($this->view(), ['filter' => $this])->render();
    }

    abstract public function view(): string;

    public function __invoke(Builder $query, $next): void
    {
        $this->apply($query);
        $next($query);
    }

    abstract public function apply(Builder $query): Builder;

}
