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
            'first_name' => ['required', 'array'],
            'first_name.en' => ['required', 'string', 'min:2', 'max:255'],
            'first_name.ka' => ['required', 'string', 'min:2', 'max:255'],

            'last_name' => ['required', 'array'],
            'last_name.en' => ['required', 'string', 'min:2', 'max:255'],
            'last_name.ka' => ['required', 'string', 'min:2', 'max:255'],

            'country' => ['required', 'array'],
            'country.en' => ['required', 'string', 'min:2', 'max:255'],
            'country.ka' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('messages.required'),
            'first_name.array'    => __('messages.array'),

            'first_name.en.required' => __('messages.required'),
            'first_name.en.string'   => __('messages.string'),
            'first_name.en.min'      => __('messages.min.string'),
            'first_name.en.max'      => __('messages.max.string'),

            'first_name.ka.required' => __('messages.required'),
            'first_name.ka.string'   => __('messages.string'),
            'first_name.ka.min'      => __('messages.min.string'),
            'first_name.ka.max'      => __('messages.max.string'),

            'last_name.required' => __('messages.required'),
            'last_name.array'    => __('messages.array'),

            'last_name.en.required' => __('messages.required'),
            'last_name.en.string'   => __('messages.string'),
            'last_name.en.min'      => __('messages.min.string'),
            'last_name.en.max'      => __('messages.max.string'),

            'last_name.ka.required' => __('messages.required'),
            'last_name.ka.string'   => __('messages.string'),
            'last_name.ka.min'      => __('messages.min.string'),
            'last_name.ka.max'      => __('messages.max.string'),

            'country.required' => __('messages.required'),
            'country.array'    => __('messages.array'),

            'country.en.required' => __('messages.required'),
            'country.en.string'   => __('messages.string'),
            'country.en.min'      => __('messages.min.string'),
            'country.en.max'      => __('messages.max.string'),

            'country.ka.required' => __('messages.required'),
            'country.ka.string'   => __('messages.string'),
            'country.ka.min'      => __('messages.min.string'),
            'country.ka.max'      => __('messages.max.string'),
        ];
    }
}
