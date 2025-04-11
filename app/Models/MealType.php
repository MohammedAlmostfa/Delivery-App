<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * Here we're using "availability_status" column in the database to store the numeric value
     * representing each meal type. The "mealTypeType" attribute is used to interact with this value.
     *
     * @var array
     */
    protected $fillable = ['mealTypeName', 'mealTypeType'];

    /**
     * Define the relationship with the Meal model.
     *
     * A MealType can have many related meals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Mapping of meal type statuses from numeric to human-readable text.
     *
     * Modify this constant to add or change meal categories.
     *
     * 0 => 'فطور' (Breakfast)
     * 1 => 'غداء' (Lunch)
     * 2 => 'عشاء' (Dinner)
     * 3 => 'حلويات' (Desserts)
     * 4 => 'مشروبات' (Drinks)
     *
     * @var array
     */
    const STATUS_MAP = [
        0 => 'فطور',
        1 => 'غداء',
        2 => 'عشاء',
        3 => 'حلويات',
        4 => 'مشروبات'
    ];

    /**
     * Accessor for the "mealTypeType" attribute.
     *
     * This accessor converts the numeric value stored in the "availability_status" column into
     * its corresponding human-readable meal type, using the STATUS_MAP.
     *
     * @return string The human-readable meal type.
     */
    public function getMealTypeTypeAttribute(): string
    {
        return self::STATUS_MAP[$this->attributes['mealTypeType']] ?? 'Unknown';
    }

    /**
     * Mutator for the "mealTypeType" attribute.
     *
     * This mutator converts a human-readable meal type into its corresponding numeric value
     * and stores it in the "availability_status" column. It uses an inverted mapping from STATUS_MAP.
     *
     * @param string $value The human-readable meal type.
     * @return void
     */
    public function setMealTypeTypeAttribute($value): void
    {
        $flippedMap = array_flip(self::STATUS_MAP);
        $this->attributes['mealTypeType'] = $flippedMap[$value] ?? 0;
    }
}
