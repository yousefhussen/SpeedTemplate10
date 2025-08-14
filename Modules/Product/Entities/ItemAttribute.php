<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class  ItemAttribute extends Model
{
    protected $table = 'item_attributes';

    protected $fillable = [
        'item_id',
        'color',
        'size',
        'amount',
        'price',
    ];

    // Relationships
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function images()
    {
        return $this->hasMany(ItemAttributeImage::class);
    }
}
