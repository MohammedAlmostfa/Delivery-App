<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderData extends FormRequest
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
          'restaurant_id' => 'required|exists:restaurants,id',
          'latitude'     => 'required|numeric',
          'longitude'    => 'required|numeric',
          'payment_method' => 'required|string|in:cash,card,online',
          'meals'        => 'required|array|min:1',
          'meals.*.meal_id' => 'required|exists:meals,id',
          'meals.*.quantity' => 'required|integer|min:1',
      ];

    }
}
