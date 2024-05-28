<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
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
 *
 * @method static Category|CategoryQueryBuilder query()
 *
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

    public function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new CategoryQueryBuilder($query);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
