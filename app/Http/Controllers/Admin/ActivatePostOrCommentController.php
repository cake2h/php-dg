<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\Admin\ActivatePostOrCommentRequest;

class ActivatePostOrCommentController extends Controller
{
    public function update(ActivatePostOrCommentRequest $request)
    {
        $validated = $request->validated();

        if (!empty($validated['posts'])) {
            foreach ($validated['posts'] as $p) {
                Post::query()->where('id', $p['id'])->update(['is_active' => (bool) $p['is_active']]);
            }
        }

        if (!empty($validated['comments'])) {
            foreach ($validated['comments'] as $c) {
                Comment::query()->where('id', $c['id'])->update(['is_active' => (bool) $c['is_active']]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}


