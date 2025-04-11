<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CodingPartners\TranslaGenius\Traits\Translatable;

/**
 * Class Restaurant
 *
 * Represents a restaurant entity that offers meals and interacts with users.
 */
class Restaurant extends Model
{
    use SoftDeletes, Translatable; // Enables soft deletion and translation functionalities.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_name',   // Name of the restaurant
        'latitude',          // Geographical latitude
        'longitude',         // Geographical longitude
        'restaurantType_id', // ID referencing the restaurant type
        'user_id',           // ID referencing the user who owns the restaurant
    ];

    /**
     * Get the type of restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurantType()
    {
        return $this->belongsTo(RestaurantType::class, 'restaurantType_id');
    }

    /**
     * Get the user associated with the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all meals offered by the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meals()
    {
        return $this->hasMany(Meal::class); // A restaurant can have multiple meals.
    }

    /**
     * Get the contact information of the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contactInf()
    {
        return $this->hasOne(ContactInf::class);
    }

    /**
     * Get all ratings associated with the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get all offers associated with meals in the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function offers()
    {
        return $this->hasManyThrough(
            Offer::class,      // Target model (offers)
            Meal::class,       // Intermediate model (meals)
            'restaurant_id',   // Foreign key in the meals table
            'meal_id',         // Foreign key in the offers table
            'id',              // Primary key in the restaurants table
            'id'               // Primary key in the meals table
        );
    }
}
