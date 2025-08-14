<?php


namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ItemAttributeImage extends Model
{
    protected $fillable = ['item_attribute_id', 'image'];

    public function attribute()
    {
        return $this->belongsTo(ItemAttribute::class);
    }
}
