<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? 'NULL';
        return [
            'external_id' => ['sometimes','integer','unique:users,external_id,'.$userId],
            'name' => ['sometimes','string'],
            'last_name' => ['sometimes','string'],
            'email' => ['sometimes','email','unique:users,email,'.$userId],
            'phone' => ['nullable','string'],
            'password' => ['sometimes','string','min:6'],
        ];
    }
}


