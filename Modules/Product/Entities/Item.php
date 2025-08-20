<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Product\Entities\Review;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'name',
        'brand',
        'image',
        'totalRating'
    ];

    // Relationships
    public function attributes(): HasMany
    {
        return $this->hasMany(ItemAttribute::class, 'item_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'item_categories',
            'item_id',
            'categoryId'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'item_id');
    }
}
