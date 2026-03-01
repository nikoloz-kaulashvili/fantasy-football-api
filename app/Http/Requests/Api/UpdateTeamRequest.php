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
            'name.required' => __('messages.required'),
            'name.array'    => __('messages.array'),

            'name.en.required' => __('messages.required'),
            'name.en.string'   => __('messages.string'),
            'name.en.min'      => __('messages.min.string'),
            'name.en.max'      => __('messages.max.string'),

            'name.ka.required' => __('messages.required'),
            'name.ka.string'   => __('messages.string'),
            'name.ka.min'      => __('messages.min.string'),
            'name.ka.max'      => __('messages.max.string'),

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
