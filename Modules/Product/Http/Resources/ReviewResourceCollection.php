<?php
// File: Modules/Product/Http/Resources/ReviewCollection.php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;

class ReviewResourceCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => ReviewResource::collection($this->collection),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        if (property_exists(self::class, $index)) {
            return $index;
        }

        return parent::originalAttribute($index);
    }

    public static function transformedAttribute($index)
    {
        if (property_exists(self::class, $index)) {
            return $index;
        }

        return parent::transformedAttribute($index);
    }
}
