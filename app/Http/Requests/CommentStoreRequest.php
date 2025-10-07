<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required','integer','exists:posts,id'],
            'name' => ['required','string'],
            'email' => ['required','email'],
            'description' => ['required','string'],
        ];
    }
}


