<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model
{
    protected $fillable = ['restaurantTypeName'];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

}
