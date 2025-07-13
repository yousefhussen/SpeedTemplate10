<?php

namespace Modules\Profile\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\ItemAttribute;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'item_attributes_id',
        'quantity',
    ];

    /**
     * Get the user associated with the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the item associated with the cart.
     */
    public function item_attribute()
    {
        return $this->belongsTo(ItemAttribute::class, 'item_attributes_id');
    }
}
