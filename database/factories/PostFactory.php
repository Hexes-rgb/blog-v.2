<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::inRandomOrder()->take(rand(1, count(User::all())))->pluck('id')->first(),
            'title' => fake()->unique()->sentence(),
            'content' => fake()->unique()->text(),

        ];
    }
}
