<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'condition' => 'sometimes|in:new,used',
            'photos' => 'sometimes|json',
            'category_id' => 'sometimes|exists:categories,id',
            'location' => 'sometimes|string',
        ];
    }
}