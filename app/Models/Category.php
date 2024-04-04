<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int                      $id
 * @property string                   $slug
 * @property string                   $title
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 *
 * @property-read Collection<Product> $products
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $category) {
            $category->slug = $category->slug ?? str($category->title)->slug();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
