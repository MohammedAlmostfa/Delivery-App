<?php

namespace App\Http\Requests\OfferRequest;

use Illuminate\Foundation\Http\FormRequest;

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
            'from' => 'required|date|after_or_equal:now',
            'to' => 'required|date|after:from',
            'new_price' => 'required|numeric|min:0'
        ];
    }


}
