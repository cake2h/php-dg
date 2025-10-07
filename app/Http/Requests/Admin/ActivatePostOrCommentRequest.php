<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivatePostOrCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'posts' => ['array'],
            'posts.*.id' => ['integer','exists:posts,id'],
            'posts.*.is_active' => ['boolean'],
            'comments' => ['array'],
            'comments.*.id' => ['integer','exists:comments,id'],
            'comments.*.is_active' => ['boolean'],
        ];
    }
}


