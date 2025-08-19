<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'review_id' => $this->review_id,
            'image_url' => $this->image_url,
        ];
    }
}
