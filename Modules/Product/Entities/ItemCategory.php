<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemCategory extends Pivot
{
    protected $table = 'item_categories';
    protected $fillable = ['itemId', 'categoryId'];
}
