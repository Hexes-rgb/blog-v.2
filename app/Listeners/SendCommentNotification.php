<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Comment;
use App\Events\CommentCreated;
use App\Mail\CommentNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $comment = $event->comment;
        if ($comment->comment_id == null) {
            $recipient = User::find($comment->post->author->id);
        } else {
            $recipient = User::find(Comment::find($comment->comment_id)->author->id);
        }
        if ($recipient->id != $comment->author->id) {
            Mail::to($recipient)->send(new CommentNotification($comment, $recipient));
        }
    }
}
