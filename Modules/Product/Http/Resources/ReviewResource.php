<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Modules\Auth\Http\Resources\UserResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $request->user();
        $isLiked = $user ? $this->likes()->where('user_id', $user->id)->exists() : false;

        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'title' => $this->title,
            'body' => $this->body,
            'purchase_verified' => (bool) $this->purchase_verified,
            'likes_count' => $this->whenLoaded('likes', $this->likes->count()),
            'is_liked' => $isLiked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'images' => ReviewImageResource::collection($this->whenLoaded('images')),
            'links' => [
                'like' => URL::route('reviews.like', $this->id),
                'report' => URL::route('reviews.report', $this->id),
            ],
        ];
    }
}
