<?php

namespace Modules\Product\Http\Resources;

use http\Url;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => Url('images/categories/'.$this->image),
        ];
    }
}
