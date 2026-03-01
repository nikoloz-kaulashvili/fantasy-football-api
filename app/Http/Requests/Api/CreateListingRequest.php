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
            'player_id.required' => __('messages.required'),
            'player_id.integer' => __('messages.integer'),
            'player_id.exists' => __('messages.exists'),

            'price.required' => __('messages.required'),
            'price.integer' => __('messages.integer'),
            'price.min' => __('messages.min.numeric'),
        ];
    }
}
