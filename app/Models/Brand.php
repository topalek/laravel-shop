<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int                      $id
 * @property string                   $slug
 * @property string                   $title
 * @property string                   $thumbnail
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 * @property-read Collection<Product> $products
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $brand) {
            $brand->slug = $brand->slug ?? str($brand->title)->slug();
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
