<?php

namespace App\Http\Requests\RestaurantRequest;

use Illuminate\Foundation\Http\FormRequest;

class GetNearRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|integer|min:1',
            'restaurantType' => 'nullable|array|min:1',
            'restaurantType.*.restaurantType_id' => 'nullable|exists:restaurant_types,id',
            'mealType' => 'nullable|array|min:1',
            'mealType.*.mealType_id' => 'nullable|exists:meal_types,id',
        ];
    }
}
