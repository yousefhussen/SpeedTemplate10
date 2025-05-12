<?php

namespace Modules\Wishlist\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class Wishlist extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
