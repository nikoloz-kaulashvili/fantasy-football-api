<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.required'),
            'name.string' => __('messages.string'),
            'name.max' => __('messages.max.string'),

            'email.required' => __('messages.required'),
            'email.email' => __('messages.email'),
            'email.unique' => __('messages.unique'),

            'password.required' => __('messages.required'),
            'password.min' => __('messages.min.string'),
            'password.confirmed' => __('messages.confirmed'),
        ];
    }
}
