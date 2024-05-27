<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (!$this->{$this->slugColumn()}) {
            $slug = $this->uniqueSlug(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    protected function slugFrom(): string
    {
        return 'title';
    }

    protected function uniqueSlug(string $value): string
    {
        $originalSlug = $value;
        $i = 0;
        while ($this->isSlugExists($value)) {
            $i++;
            $value = "$value-$i";
        }
        return $value;
    }

    protected function isSlugExists(string $value): bool
    {
        $query = $this->newQuery()
            ->where($this->slugColumn(), $value)
//                ->where($this->getKeyName(), !=, $this->getKey())
            ->withoutGlobalScopes()
        ;

        return $query->exists();
    }
}
