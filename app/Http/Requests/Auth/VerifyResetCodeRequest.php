<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyResetCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:6',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'No user found with this email address.',
            'code.required' => 'The reset code is required.',
            'code.numeric' => 'The reset code must be a numeric value.',
            'code.digits' => 'The reset code must be 6 digits.',
        ];
    }
}
