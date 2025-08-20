<?php
// File: Modules/Product/Http/Resources/ReviewCollection.php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ReviewResource::collection($this->collection),
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            // Add other attributes as needed
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            // Add other attributes as needed
        ];

        return $attributes[$index] ?? null;
    }
}
