<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name'];

    // Relationships
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            Item::class,
            'item_categories',
            'categoryId',
            'item_id'
        );
    }
}
