<?php

namespace Domain\Product\Models;

use App\Casts\PriceCast;
use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
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
 * @property string $text
 * @property string $json_properties
 * @property string                    $thumbnail
 * @property int                       $price
 * @property int    $sorting
 * @property bool   $on_home_page
 * @property Carbon                    $created_at
 * @property Carbon                    $updated_at
 *
 * @property-read Collection<Category> $categories
 * @property-read Brand                $brand
 *
 * @method static Product|ProductQueryBuilder query()
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
        'json_properties'
    ];

    protected $casts = [
        'on_home_page'    => 'boolean',
        'price'           => PriceCast::class,
        'json_properties' => 'array',
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

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (Product $product) {
            ProductJsonProperties::dispatch($product)->delay(now()->addSeconds(10));
        });
    }
}
