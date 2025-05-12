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
            'price' => $this->price,
            'image' => Url(asset($this->image)), // Adjust based on your storage
            'totalRating' => $this->totalRating,
            'attributes' => $this->attributes,
            'categories' => $this->categories,
        ];
    }
}
