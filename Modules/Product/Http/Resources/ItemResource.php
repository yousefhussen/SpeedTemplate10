<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'image' => Url(asset($this->image)), // Adjust based on your storage
            'totalRating' => $this->totalRating,
            'attributes' => $this->attributes->map(function ($attribute) {
                return [
                    'id' => $attribute->id,
                    'price' => $attribute->price,
                    'quantity' => $attribute->amount,
                    'color' => $attribute->color,
                    'size' => $attribute->size,
                    'images' => $attribute->images->map(function ($image) {
                        return Url(asset($image->image)); // Adjust based on your storage
                    }),

                ];
            }),

        ];
    }
}
