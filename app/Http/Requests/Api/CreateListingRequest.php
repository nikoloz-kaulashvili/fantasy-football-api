<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest  extends FormRequest
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
            'player_id' => ['required', 'integer', 'exists:players,id'],
            'price' => ['required', 'integer', 'min:1'], 
        ];
    }

    public function messages(): array
    {
        return [
            'player_id.required' => __('validation.required'),
            'player_id.integer' => __('validation.integer'),
            'player_id.exists' => __('validation.exists'),

            'price.required' => __('validation.required'),
            'price.integer' => __('validation.integer'),
            'price.min' => __('validation.min.numeric'),
        ];
    }
}
