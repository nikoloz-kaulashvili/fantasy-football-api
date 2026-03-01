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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'country' => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required'),
            'name.string'   => __('validation.string'),
            'name.min'      => __('validation.min.string'),
            'name.max'      => __('validation.max.string'),

            'country.required' => __('validation.required'),
            'country.string'   => __('validation.string'),
            'country.min'      => __('validation.min.string'),
            'country.max'      => __('validation.max.string'),
        ];
    }
}
