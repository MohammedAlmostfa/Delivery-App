<?php

namespace App\Http\Requests\mealrequest;

use App\Rules\CheckImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMealData extends FormRequest
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
            'mealName' => 'nullable|string|max:80',
            'description'=>'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'mealType_id' => 'nullable|exists:meal_types,id',
            'availability_status' => 'nullable|integer|min:0|max:3',
            'time_of_prepare'=>'nullable|date_format:H:i',
                 'image' => ['nullable', 'image', new CheckImage]

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
