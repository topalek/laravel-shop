<?php

namespace App\Models;

use App\Casts\PriceCast;
use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

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
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'price',
        'brand_id',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    protected $casts = [
        'on_home_page' => 'boolean',
        'price'        => PriceCast::class
    ];


    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeFiltered(Builder $query): Builder
    {
        return $query->when(request('filters.brands'), function (Builder $query) {
            $query->whereIn('brand_id', request('filters.brands'));
        })->when(request('filters.price'), function (Builder $query) {
            $query->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 100000) * 100
            ]);
        });
    }

    public function scopeSorted(Builder $query): Builder
    {
        // моя реализация
        /*return match (request('sort')) {
            'price'  => $query->orderBy('price'),
            '-price' => $query->orderBy('price', 'desc'),
            'title'  => $query->orderBy('title'),
            default  => $query->orderBy('sorting'),
        };*/

        return $query->when(request('sort'), function (Builder $q) {
            $column = str(request('sort'));

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'desc' : 'asc';
                $q->orderBy((string)$column->remove('-'), $direction);
            }
        });
    }

    public function scopeHomePage(Builder $query): Builder
    {
        return $query->where('on_home_page', true)->orderBy('sorting')->limit(6);
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
