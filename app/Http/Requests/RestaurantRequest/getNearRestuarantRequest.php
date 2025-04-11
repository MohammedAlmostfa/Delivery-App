<?php

namespace App\Http\Requests\RestaurantRequest;

use Illuminate\Foundation\Http\FormRequest;

class getNearRestuarantRequest extends FormRequest
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
        'latitude' => 'nullable',
        'longitude' => 'nullable',
        'radius'=>'nullable|integer',
        'restaurantType_id'=>'nullable|exists:meal_types,id',
        ];
    }
}
