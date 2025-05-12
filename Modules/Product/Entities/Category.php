<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name'];

    // Relationships
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            Item::class,
            'item_categories',
            'categoryId',
            'itemId'
        );
    }
}
