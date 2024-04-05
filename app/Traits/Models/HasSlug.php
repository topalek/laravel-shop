<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $slug = str($model->{self::slugFrom()})->slug();
            $count = self::query()->where('slug', 'like', "%$slug%")->count();
            if ($count > 0) {
                $slug .= "-" . $count + 1;
            }
            $model->slug = $model->slug ?? $slug;
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }

}
