<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function create()
    {
        return view('send-mail', [
            'tags' => Tag::popular()->orderBy('posts_count', 'desc')->orderBy('tags.name', 'asc')->limit(5)->get()
        ]);
    }
    public function store(Request $request)
    {
        $to_name = 'Dear Customer';
        $to_email = $request->input('email');
        $files = $request->allFiles();
        $mailFiles = array();
        foreach ($files['files'] as $file) {
            $file->move(public_path('public/mailFiles/'), $file->getClientOriginalName());
            array_push($mailFiles, public_path('public/mailFiles/' . $file->getClientOriginalName()));
        }
        $data = array('name' => $to_name, 'body' => $request->input('message'));
        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email, $mailFiles) {
            $message->to($to_email, $to_name)
                ->subject('test');
            // $message->from("hello@example.com");

            foreach ($mailFiles as $file) {
                $message->attach($file);
            }
        });
        return redirect()->route('mail.create');
        // return response()->json(['success' => 'Mail send\'s successfully.']);
    }
}
