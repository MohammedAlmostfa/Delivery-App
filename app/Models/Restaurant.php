<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'restaurant_name',
        'location',
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
}
