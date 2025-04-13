<?php

namespace App\Http\Requests\OfferRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOfferData extends FormRequest
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
            'meal_id' => 'required|exists:meals,id',
            'from' => 'required|date|after_or_equal:today', // Ensuring only the date part
            'to' => 'required|date|after:from',
            'new_price' => 'required|numeric|min:0'
        ];
    }

    /**
     * Prepare the input before validation to store only date (without time).
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'from' => date('Y-m-d', strtotime($this->input('from'))),
            'to' => date('Y-m-d', strtotime($this->input('to'))),
        ]);
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
