<?php

namespace Modules\Auth\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail , JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'code', 'code_type', 'google_id', 'avatar', 'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function tempTokens()
    {
        return $this->hasMany(TempToken::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // File: Modules/Auth/Entities/User.php

    public function addresses()
    {
        return $this->hasMany(\Modules\Profile\Entities\Address::class);
    }

    /**
     * Get all likes made by this user
     */
    public function reviewLikes()
    {
        return $this->hasMany(\Modules\Product\Entities\ReviewLike::class);
    }

    /**
     * Check if the user has liked a specific review
     * 
     * @param \Modules\Product\Entities\Review $review
     * @return bool
     */
    public function hasLikedReview($review)
    {
        if (!$review) {
            return false;
        }
        
        return $this->reviewLikes()
            ->where('review_id', $review->id)
            ->exists();
    }
}
