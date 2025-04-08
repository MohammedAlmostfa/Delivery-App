<?php

namespace App\Http\Requests\RestaurantRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantData extends FormRequest
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
            'restaurant_name' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            "restaurantType_id"=>'required|exists:restaurant_types,id',
            'whatsappNumber' => 'required|string|max:15|unique:contact_infs,whatsappNumber',
            'phoneNumber1' => 'required|string|max:15|unique:contact_infs,phoneNumber1',
            'phoneNumber2' => 'nullable|string|max:15|unique:contact_infs,phoneNumber2|different:phoneNumber1',
            'email' => 'required|email|max:255|unique:contact_infs,email',
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
