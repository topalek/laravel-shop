<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Builder;
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



    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeHomePage(Builder $query): Builder
    {
        return $query->where('on_home_page', true)->orderBy('sorting')->limit(6);
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }
}
