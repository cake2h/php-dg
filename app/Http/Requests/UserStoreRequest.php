<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'external_id' => ['required','integer','unique:users,external_id'],
            'name' => ['required','string'],
            'last_name' => ['required','string'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['nullable','string'],
            'password' => ['required','string','min:6'],
        ];
    }
}


