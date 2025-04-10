<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable=[
        'rate',
        'review',
        'user_id',
        'restaraunt_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaraunt_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
