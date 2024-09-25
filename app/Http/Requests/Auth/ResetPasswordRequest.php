<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reset_token' => 'required|string',  // Reset token from verify-reset-code
            'password' => 'required|string|min:8',
        ];
    }

}
