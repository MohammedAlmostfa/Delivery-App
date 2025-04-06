<?php
namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // JWT Identifier
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // JWT Custom Claims
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'user_id');
    }
}
