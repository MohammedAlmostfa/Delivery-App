<?php

namespace App\Http\Requests\RatingRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingData extends FormRequest
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
            'rate' => 'nullable|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ];
    }
}
