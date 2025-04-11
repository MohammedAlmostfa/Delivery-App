<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Offer
 *
 * Represents a discount or promotional offer applied to a meal.
 */
class Offer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meal_id',    // Reference to the associated meal
        'new_price',  // Discounted price for the meal
        'from',       // Start date of the offer
        'to',         // End date of the offer
    ];

    /**
     * Get the meal associated with this offer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id'); // Relationship linking offer to meal
    }
}
