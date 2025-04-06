<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    protected $fillable = ['mealTypeName'];

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
