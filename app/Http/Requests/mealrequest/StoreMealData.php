<?php

namespace App\Http\Requests\mealrequest;

use App\Rules\CheckImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'mealType_id' => 'required|exists:meal_types,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'time_of_prepare' => 'required|date_format:H:i',
            'image' => ['required', 'image', new CheckImage]

        ];
    }
    /**
     * Handle a failed validation attempt.
     * This method is called when validation fails.
     * Logs failed attempts and throws validation exception.
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'error',
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
