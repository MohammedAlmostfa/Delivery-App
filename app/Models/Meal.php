<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'mealName',
        'price',
        'mealType_id',
        'restaurant_id',
    ];

    public function mealType()
    {
        return $this->belongsTo(MealType::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
