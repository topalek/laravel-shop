<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Support\Traits\Models\HasSlug;

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
    use HasSlug;
    protected $fillable = [
        'slug',
        'title',
        'on_home_page',
        'sorting',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeHomePage(Builder $query): Builder
    {
        return $query->where('on_home_page', true)->orderBy('sorting')->limit(10);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}