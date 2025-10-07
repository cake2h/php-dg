<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportJsonPlaceholder extends Command
{
    protected $signature = 'import:jsonplaceholder {--activate}';

    protected $description = 'Импорт пользователей, постов и комментариев';

    public function handle(): int
    {
        $activate = (bool) $this->option('activate');

        DB::transaction(function () use ($activate) {
            $users = Http::timeout(30)->get('https://jsonplaceholder.typicode.com/users')->json();
            foreach ($users as $u) {
                User::query()->updateOrCreate(
                    ['external_id' => $u['id']],
                    [
                        'name' => $u['name'],
                        'last_name' => $u['username'],
                        'email' => $u['email'],
                        'phone' => $u['phone'] ?? null,
                        'password' => 'imported',
                    ]
                );
            }

            $posts = Http::timeout(30)->get('https://jsonplaceholder.typicode.com/posts')->json();
            foreach ($posts as $p) {
                $user = User::query()->where('external_id', $p['userId'])->first();
                if (!$user) {
                    continue;
                }

                Post::query()->updateOrCreate(
                    ['external_id' => $p['id']],
                    [
                        'user_id' => $user->id,
                        'title' => $p['title'],
                        'description' => $p['body'],
                        'is_active' => $activate,
                    ]
                );
            }

            $comments = Http::timeout(30)->get('https://jsonplaceholder.typicode.com/comments')->json();
            foreach ($comments as $c) {
                $post = Post::query()->where('external_id', $c['postId'])->first();
                if (!$post) {
                    continue;
                }

                Comment::query()->updateOrCreate(
                    ['external_id' => $c['id']],
                    [
                        'post_id' => $post->id,
                        'name' => $c['name'],
                        'email' => $c['email'],
                        'description' => $c['body'],
                        'is_active' => $activate,
                    ]
                );
            }
        });

        $this->info('Import completed');
        return self::SUCCESS;
    }
}


