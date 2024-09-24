<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . auth()->id(),
            'location' => 'sometimes|required|string',
        ];
    }
}
