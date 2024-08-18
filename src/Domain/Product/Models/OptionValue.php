<?php

namespace Domain\Product\Models;

use Database\Factories\OptionValueFactory;
use Domain\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'option_id'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function newCollection(array $models = []): OptionValueCollection
    {
        return new OptionValueCollection($models);
    }

    protected static function newFactory(): OptionValueFactory
    {
        return OptionValueFactory::new();
    }
}
