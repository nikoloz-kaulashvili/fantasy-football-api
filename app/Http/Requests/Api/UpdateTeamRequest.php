<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.en' => ['required', 'string', 'min:3', 'max:255'],
            'name.ka' => ['required', 'string', 'min:3', 'max:255'],

            'country' => ['required', 'array'],
            'country.en' => ['required', 'string', 'min:2', 'max:255'],
            'country.ka' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required'),
            'name.array'    => __('validation.array'),

            'name.en.required' => __('validation.required'),
            'name.en.string'   => __('validation.string'),
            'name.en.min'      => __('validation.min.string'),
            'name.en.max'      => __('validation.max.string'),

            'name.ka.required' => __('validation.required'),
            'name.ka.string'   => __('validation.string'),
            'name.ka.min'      => __('validation.min.string'),
            'name.ka.max'      => __('validation.max.string'),

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
