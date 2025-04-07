<?php

namespace App\Http\Requests\RestaurantRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateRestaurantData extends FormRequest
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
            'restaurant_name' => 'nullable|string"',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'whatsappNumber' => 'nullable|string|max:15|unique:contact_infs,whatsappNumber',
            'phoneNumber1' => 'nullable|string|max:15|unique:contact_infs,phoneNumber1',
            'phoneNumber2' => 'nullable|string|max:15|unique:contact_infs,phoneNumber2',
            'email' => 'nullable|email|max:255|unique:contact_infs,email',
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
