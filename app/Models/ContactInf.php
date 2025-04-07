<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInf extends Model
{
    protected $fillable = ['restaurant_id', 'whatsappNumber', 'phoneNumber1','phoneNumber2', 'email'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
