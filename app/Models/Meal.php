<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mealName',
        'price',
        "description",
        'mealType_id',
        'restaurant_id',
        'availability_status',
        'time_of_prepare',
    ];

    /**
     * Status mapping for human-readable conversion.
     */
    const STATUS_MAP = [
        0 => 'Within less than an hour',
        1 => 'Available',
        2 => 'Within several hours',
        3 => 'For the next day',
    ];


    /**
     * Convert the availability_status value to a human-readable string.
     *
     * @param int $value The numeric status value.
     * @return string Human-readable status.
     */
    public function getAvailabilityStatusAttribute(): string
    {
        return self::STATUS_MAP[$this->attributes['availability_status']] ?? 'Unknown';
    }

    /**
     * Set the availability_status value using a human-readable string.
     *
     * @param string $value The human-readable status.
     * @return void
     */
    public function setAvailabilityStatusAttribute($value): void
    {
        $flippedMap = array_flip(self::STATUS_MAP);
        $this->attributes['availability_status'] = $flippedMap[$value] ?? 0;
    }

    /**
     * Relationship with MealType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mealType()
    {
        return $this->belongsTo(MealType::class, 'mealType_id');
    }

    /**
     * Relationship with Restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }
}
