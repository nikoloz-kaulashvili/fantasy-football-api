<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayerRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name'  => ['required', 'string', 'min:2', 'max:255'],
            'country'    => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('validation.required'),
            'first_name.string'   => __('validation.string'),
            'first_name.min'      => __('validation.min.string'),
            'first_name.max'      => __('validation.max.string'),

            'last_name.required' => __('validation.required'),
            'last_name.string'   => __('validation.string'),
            'last_name.min'      => __('validation.min.string'),
            'last_name.max'      => __('validation.max.string'),

            'country.required' => __('validation.required'),
            'country.string'   => __('validation.string'),
            'country.min'      => __('validation.min.string'),
            'country.max'      => __('validation.max.string'),
        ];
    }
}
