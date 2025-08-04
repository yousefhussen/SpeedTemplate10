<?php

namespace Modules\Profile\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class Address extends Model
{

    protected $fillable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'phone_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
