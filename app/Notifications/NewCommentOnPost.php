<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentOnPost extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Comment $comment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New comment on your post')
            ->greeting('Hello')
            ->line('A new comment was added to your post:')
            ->line($this->comment->description)
            ->line('From: ' . $this->comment->name . ' <' . $this->comment->email . '>');
    }
}


