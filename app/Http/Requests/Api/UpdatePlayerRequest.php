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
            'first_name.required' => __('validation.required'),
            'first_name.array'    => __('validation.array'),

            'first_name.en.required' => __('validation.required'),
            'first_name.en.string'   => __('validation.string'),
            'first_name.en.min'      => __('validation.min.string'),
            'first_name.en.max'      => __('validation.max.string'),

            'first_name.ka.required' => __('validation.required'),
            'first_name.ka.string'   => __('validation.string'),
            'first_name.ka.min'      => __('validation.min.string'),
            'first_name.ka.max'      => __('validation.max.string'),

            'last_name.required' => __('validation.required'),
            'last_name.array'    => __('validation.array'),

            'last_name.en.required' => __('validation.required'),
            'last_name.en.string'   => __('validation.string'),
            'last_name.en.min'      => __('validation.min.string'),
            'last_name.en.max'      => __('validation.max.string'),

            'last_name.ka.required' => __('validation.required'),
            'last_name.ka.string'   => __('validation.string'),
            'last_name.ka.min'      => __('validation.min.string'),
            'last_name.ka.max'      => __('validation.max.string'),

            'country.required' => __('validation.required'),
            'country.array'    => __('validation.array'),

            'country.en.required' => __('validation.required'),
            'country.en.string'   => __('validation.string'),
            'country.en.min'      => __('validation.min.string'),
            'country.en.max'      => __('validation.max.string'),

            'country.ka.required' => __('validation.required'),
            'country.ka.string'   => __('validation.string'),
            'country.ka.min'      => __('validation.min.string'),
            'country.ka.max'      => __('validation.max.string'),
        ];
    }
}
