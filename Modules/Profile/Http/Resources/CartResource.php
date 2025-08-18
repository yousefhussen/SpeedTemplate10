<?php

namespace Modules\Profile\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_attributes_id' => $this->item_attributes_id,
            'quantity' => $this->quantity,
            'item' => [
                'id' => $this->item_attribute->id,
                'color' => $this->item_attribute->color,
                'size' => $this->item_attribute->size,
                'image' => url($this->item_attribute->item->image),
                'price' => (string) $this->item_attribute->item->price,
                'name' => $this->item_attribute->item->name,


            ],
            'created_at' => $this->created_at,


        ];
    }
}
