<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'No user found with this email address.',
            'otp.required' => 'The OTP code is required.',
            'otp.numeric' => 'The OTP must be a numeric value.',
            'otp.digits' => 'The OTP must be 6 digits.',
        ];
    }
}
