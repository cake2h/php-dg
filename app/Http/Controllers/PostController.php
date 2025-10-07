<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['user', 'comments' => function ($q) {
                $q->active()->latest()->limit(2);
            }])
            ->active()
            ->latest('id')
            ->paginate(12);

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        if (!$post->is_active) {
            abort(404);
        }
        $post->load(['user', 'comments' => function ($q) {
            $q->active()->latest()->limit(2);
        }]);
        return new PostResource($post);
    }
}


