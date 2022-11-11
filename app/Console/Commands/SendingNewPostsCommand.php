<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Mail\PostDelivery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendingNewPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newPosts:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::dayAway()->get();
        $posts = Post::dailyPosts()->get();
        Mail::bcc($users)->send(new PostDelivery($posts));
    }
}
