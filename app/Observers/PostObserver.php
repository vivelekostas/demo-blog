<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $post->load('comments');

        Cache::tags(['posts_index'])->flush();
        Cache::put('posts:' . $post->id, $post);
        Cache::tags(['posts_index'])->rememberForever('posts:all' . 1, function () {
            return Post::paginate(10);
        });
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $post->load('comments');
        Cache::put('posts:' . $post->id, $post);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        Cache::tags(['posts_index'])->flush();
        Cache::forget('posts:' . $post->id);
    }
}
