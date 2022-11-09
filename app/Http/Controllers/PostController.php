<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Exports\PostsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        // phpinfo();
        return view('main', [
            'posts' => Post::trends()->orderBy('rating', 'desc')->paginate(4),
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }

    public function show($post_id)
    {
        // dd(Tag::all('name')->toJson());
        $post = Post::findOrFail($post_id);
        // dd($post->views->where('id', Auth::id())->last()->views->created_at);
        if (Auth::user()) {
            if ($post->views->where('id', Auth::id())->isEmpty()) {
                $post = $post->views()->attach(Auth::user());
            }
            if (Carbon::now()->diffInHours($post->views->where('id', Auth::id())->last()->views->created_at) > 3) {
                $post->views()->attach(Auth::user());
            }
        }
        return view('read-post', [
            'post' => $post,
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }

    public function edit($post_id)
    {

        $post = Post::where('id', '=', $post_id)->withTrashed()->get()->first();
        return view('post-redactor', ['tags' => Tag::popular()->get(), 'post' => $post]);
    }

    public function create()
    {
        return view('post-redactor', ['tags' => Tag::popular()->get()]);
    }

    public function update(UpdatePostRequest $request)
    {
        $validated = $request->validated();
        $post_id = $request->input('post_id');
        $image = $validated['image'];
        $post = Post::where('id', '=', $post_id)->first();
        if ($image) {
            $post->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);
        }
        return redirect()->route('post.edit', $post_id);
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $image = $validated['image'];
        if (!empty($image)) {
            $post = Post::create([
                'author_id' => Auth::id(),
                'title' => $validated['title'],
                'content' => $validated['content'],
                'image' => date('YmdHi') . $image->getClientOriginalName(),
            ]);
            $image->move(public_path('public/postsImages'), date('YmdHi') . $image->getClientOriginalName());
        } else {
            $post = Post::create([
                'author_id' => Auth::id(),
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);
        }
        return redirect()->route('post.edit', $post->id);
    }

    public function destroy(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::findOrFail($post_id);
        $post->delete();
        return redirect()->route('post.edit', $post->id);
    }

    public function restore(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::withTrashed()->findOrFail($post_id);
        $post->restore();
        return redirect()->route('post.edit', $post->id);
    }

    public function export($post_id)
    {
        (new PostsExport($post_id))->store('post' . $post_id . '.xlsx', 'public_exports');
        $mailFiles = array();
        array_push($mailFiles, public_path('exports/' . 'post' . $post_id . '.xlsx'));
        $to_name = Auth::user()->name;
        $to_email = Auth::user()->email;
        $data = array('name' => $to_name, 'body' => 'Take your post');
        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email, $mailFiles) {
            $message->to($to_email, $to_name)
                ->subject('Post');
            // $message->from("hello@example.com");

            foreach ($mailFiles as $file) {
                $message->attach($file);
            }
        });
        return redirect()->route('post.show', $post_id);
    }
}
