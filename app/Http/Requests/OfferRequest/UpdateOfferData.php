<?php

namespace App\Http\Requests\OfferRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferData extends FormRequest
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
            'from' => 'nullable|date|after_or_equal:now',
            'to' => 'nullable|date|after:from',
            'new_price' => 'nullable|numeric|min:0'
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
}
