<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RedisGo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сaches all posts with comments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::with('comments')->get();
        if ($posts->isNotEmpty()) {
            $posts->each(function ($post) {
                Cache::put('posts:' . $post->id, $post);
            });

            return $this->info('The command was successful!');
        }

        return $this->line('There are no posts yet!');
    }
}
