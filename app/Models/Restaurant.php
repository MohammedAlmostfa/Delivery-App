<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'restaurant_name',
        'latitude',
        'longitude',
        'restaurantType_id',
        'user_id',
    ];

    public function restaurantType()
    {
        return $this->belongsTo(RestaurantType::class, 'restaurantType_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);  // Fixed method name
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function contactInf()
    {
        return $this->hasOne(ContactInf::class);
    }
}
