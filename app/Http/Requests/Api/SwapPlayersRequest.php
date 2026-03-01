<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SwapPlayersRequest extends FormRequest
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
            'in_player_id'  => ['required', 'integer', 'exists:players,id'],
            'out_player_id' => ['required', 'integer', 'exists:players,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'in_player_id.required' => __('messages.required'),
            'in_player_id.integer'  => __('messages.integer'),
            'in_player_id.exists'   => __('messages.exists'),

            'out_player_id.required' => __('messages.required'),
            'out_player_id.integer'  => __('messages.integer'),
            'out_player_id.exists'   => __('messages.exists'),
        ];
    }
}
