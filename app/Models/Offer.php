<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
          'meal_id',
          'new_price',
          'from',
          'to',
      ];


    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');

    }
}
