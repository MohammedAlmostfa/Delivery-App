<?php
namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Psy\Command\ListCommand\FunctionEnumerator;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable , HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'latitude',
        'longitude',
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

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
