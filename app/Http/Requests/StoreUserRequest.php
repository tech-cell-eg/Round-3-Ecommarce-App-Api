<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => [
                'required',
                'string',
                'max:11',
                'regex:/^(010|011|012|015)[0-9]{8}$/',
                'unique:users,phone_number',
            ],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required!',
            'first_name.string' => 'First name must be a string!',
            'last_name.required' => 'Last name is required!',
            'last_name.string' => 'Last name must be a string!',
            'phone_number.required' => 'Phone number is required!',
            'phone_number.unique' => 'This phone number already exists!',
            'phone_number.regex' => 'Phone number must start with 010, 011, 015, or 012 followed by 8 digits.',
            'phone_number.max' => 'Phone number must not exceed 11 digits.',
            'email.required' => 'Email is required!',
            'email.email' => 'Email must be a valid email address!',
            'email.unique' => 'Email already exists!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
            'avatar.image' => 'Avatar must be an image file.',
            'avatar.mimes' => 'Avatar must be a JPEG, PNG, JPG, SVG, or GIF file.',
            'avatar.max' => 'Avatar size must not exceed 2MB.',
        ];
    }
}
