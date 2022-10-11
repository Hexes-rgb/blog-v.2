<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()
            ->count(6)
            ->create();

        foreach (Post::all() as $post) {
            $tags = Tag::inRandomOrder()->take(rand(1, count(Tag::all())))->pluck('id');
            $post->tags()->attach($tags);
        }
    }
}
