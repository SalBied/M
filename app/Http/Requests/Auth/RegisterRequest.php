<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;



class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'location' => 'required|string|max:255',
            'profile_picture' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email address is already registered.',
            'username.unique' => 'This username is already taken.',
        ];
    }
}
