<?php

namespace App\Http\Requests\mealrequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // تأكد من السماح بتنفيذ الطلب
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
            'mealName' => 'nullable|string|max:80',
            'price' => 'nullable|numeric|min:0',
            'mealType_id' => 'nullable|exists:meal_types,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'availability_status' => 'nullable|integer|min:0|max:3',
        ];
    }
}
