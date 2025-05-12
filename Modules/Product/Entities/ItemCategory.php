<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemCategory extends Pivot
{
    protected $table = 'item_categories';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['itemId', 'categoryId'];
}
