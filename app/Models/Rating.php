<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 *
 * Represents a user rating and review for a restaurant.
 */
class Rating extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate',          // Numeric rating score (e.g., 1-5 stars)
        'review',        // Text review given by the user
        'user_id',       // ID of the user who submitted the rating
        'restaraunt_id', // ID of the restaurant being rated
    ];

    /**
     * Get the restaurant associated with this rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaraunt_id'); // Links rating to a restaurant
    }

    /**
     * Get the user who submitted the rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Links rating to a user
    }
}
