<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemAttribute extends Model
{
    protected $table = 'item_attributes';

    protected $fillable = [
        'itemId',
        'color',
        'size',
        'amount'
    ];

    // Relationships
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'itemId');
    }
}
