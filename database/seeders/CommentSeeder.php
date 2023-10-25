<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        Comment::factory()
            ->count(30)
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'user_id' => $users->random()->id,
                    'post_id' => $posts->random()->id,
                ]
            ))
            ->create();
    }
}
