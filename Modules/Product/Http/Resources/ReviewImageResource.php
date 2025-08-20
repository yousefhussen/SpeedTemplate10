<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Url;

class ReviewImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [    
            'id' => $this->id,
            'review_id' => $this->review_id,
            'image_url' => Url::to(Storage::url($this->image_url)),
        ];
    }
}
