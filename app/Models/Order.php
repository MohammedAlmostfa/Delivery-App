<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'latitude',
        'longitude',
        'Payment_method',
    ];

    /**
     * Relationship with Meals (An order can have many meals).
     */
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'order_meal', 'order_id', 'meal_id')->withPivot('quantity');
    }

}
