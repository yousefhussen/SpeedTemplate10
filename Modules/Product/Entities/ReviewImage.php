<?php
namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewImage extends Model
{
    protected $fillable = [
        'review_id',
        'image_url',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
