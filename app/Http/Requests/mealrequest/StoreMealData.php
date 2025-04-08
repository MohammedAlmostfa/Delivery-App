<?php

namespace App\Http\Requests\mealrequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealData extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'mealName' => 'required|string|max:80',
            'price' => 'required|numeric|min:0',
            'mealType_id' => 'required|exists:meal_types,id',
            'restaurant_id' => 'required|exists:restaurants,id',
        ];
    }
}
