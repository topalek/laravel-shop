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
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Carbon;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @property int                       $id
 * @property string                    $slug
 * @property string                    $title
 * @property string $text
 * @property string                    $thumbnail
 * @property int                       $price
 * @property int    $sorting
 * @property bool   $on_home_page
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

    //    use Searchable;

    protected $fillable = [
        'slug',
        'title',
        'price',
        'brand_id',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
    ];

    protected $casts = [
        'on_home_page' => 'boolean',
        'price'        => PriceCast::class
    ];

    /* #[SearchUsingFullText(['title', 'text'])]
     public function toSearchableArray(): array
     {
         return [
             'title' => $this->title,
             'text'  => $this->text,
         ];
     }*/

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)->send($query)
                                   ->through(filters())
                                   ->thenReturn()
        ;
    }

    public function scopeSorted(Builder $query)
    {
        sorter()->run($query);
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
