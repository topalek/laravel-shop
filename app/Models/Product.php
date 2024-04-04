<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int                       $id
 * @property string                    $slug
 * @property string                    $title
 * @property string                    $thumbnail
 * @property int                       $price
 * @property Carbon                    $created_at
 * @property Carbon                    $updated_at
 *
 * @property-read Collection<Category> $categories
 * @property-read Brand                $brand
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'price',
        'brand_id',
        'thumbnail',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $product) {
            $product->slug = $product->slug ?? str($product->title)->slug();
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
