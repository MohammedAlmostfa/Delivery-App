<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderData extends FormRequest
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
              'latitude'     => 'nullable|numeric',
          'longitude'    => 'nullable|numeric',
          'payment_method' => 'nullable|string|in:cash,card,online',
             'meals'        => 'nullable|array|min:1',
          'meals.*.meal_id' => 'nullable|exists:meals,id',
          'meals.*.quantity' => 'nullable|integer|min:1',
        ];
    }
}
