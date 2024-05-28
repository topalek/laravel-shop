<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Support\Traits\Models\HasSlug;

/**
 * @property int                      $id
 * @property string                   $slug
 * @property string                   $title
 * @property string                   $thumbnail
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 *
 * @property-read Collection<Product> $products
 *
 * @method static Builder|BrandQueryBuilder query()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function newCollection(array $models = [])
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new BrandQueryBuilder($query);
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }
}
