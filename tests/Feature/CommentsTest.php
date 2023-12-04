<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    /** @test */
    public function test_the_user_can_store_the_comment(): void
    {
        $this->withoutExceptionHandling();

        $author = User::factory()->hasPosts(1)->create();
        $post = $author->posts[0];
        $commentator = User::factory()->create();

        $data = [ // данные необходимые для создания поста.
            'text' => 'Ololo! It`s the best post in the world!',
            // 'user_id' => $commentator->id,
            'post_id' => $post->id
        ];

        $res = $this->actingAs($commentator)->post('api/posts/' . $post->id . '/comments', $data);

        $res->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'user_id' => $commentator->id,
            'post_id' => $post->id
        ]);
    }
}
