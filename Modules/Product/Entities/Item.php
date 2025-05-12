<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'name',
        'brand',
        'price',
        'image',
        'totalRating'
    ];

    // Relationships
    public function attributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemAttribute::class, 'itemId');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'item_categories',
            'itemId',
            'categoryId'
        );
    }
}
