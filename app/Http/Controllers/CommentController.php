<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentOnPost;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    public function index(CommentIndexRequest $request)
    {
        $validated = $request->validated();

        $comments = Comment::query()
            ->where('post_id', $validated['post_id'])
            ->active()
            ->latest('id')
            ->paginate(12);

        return CommentResource::collection($comments);
    }

    public function store(CommentStoreRequest $request)
    {
        $validated = $request->validated();

        $post = Post::query()->findOrFail($validated['post_id']);

        $comment = Comment::query()->create([
            'external_id' => 0,
            'is_active' => false,
            'post_id' => $post->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'description' => $validated['description'],
        ]);

        $post->user->notify(new NewCommentOnPost($comment));

        return new CommentResource($comment);
    }
}


