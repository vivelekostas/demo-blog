<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


/**
 * TDD (test-driven development) — это подход, при котором тесты создаются раньше кода. В теории
 * позволяет обойтись вовсе без браузера (фронта) при разработке бека. Суть в том, что тесты ими-
 * тируют поведение юзера. Feature тесты для тестирования основного костяка приложения, CRUDа мо-
 * делей, как бы, базовой логики. Unit - для тестирования небольших, узкоспециализированных функ-
 * ций.
 *
 * По примеру из https://www.youtube.com/watch?v=leaXsWyfQRs&t=6367s&ab_channel=LaravelCreative
 */
class PostTest extends TestCase
{
    use RefreshDatabase; // рефрешит тестовую БД под каждый тест.

    /**
     * Метод для общего фун-ла тест-кейсов.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'accept' => 'application/json'
        ]);
    }


    /** @test */
    public function test_the_user_can_stored_the_post(): void
    {
        $this->withoutExceptionHandling();

        $data = [ // данные необходимые для создания поста.
            'title' => 'Some Title',
            'content' => 'Some very long content',
        ];

        $user = User::factory()->create();                       // тестовый юзер для post_id в посте.
        $res = $this->actingAs($user)->post('api/posts', $data); // отправка POST-запроса с данными.

        $res->assertStatus(201); // чек успешного ответа.

        $this->assertDatabaseCount('posts', 1); // чек сохранения поста в БД.
        $this->assertDatabaseHas('posts', [ // или так чекнуть.
            'title' => 'Some Title',
            'content' => 'Some very long content',
        ]);

        $post = Post::query()->first();                        // чек того, что получаем тот самый пост,
        $this->assertEquals($data['title'], $post->title);     // который только что и создали.
        $this->assertEquals($data['content'], $post->content);

        $res->assertJson([ // в случае API больше смысла в тесте json ответа, чем в http статусе ответа
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'user_id' => $post->user_id,
                'comments_count' => $post->comments_count,
                'created_at' => $post->created_at->format('Y-m-d H:m'),
                'updated_at' => $post->updated_at->format('Y-m-d H:m'),
            ]
        ]);
    }

    // Пример тестирования валидации. Для огромных форм, наверное, есть смысл выносить в
    // в отдельный тестовый класс, чтобы основной тест модели не стал слишком здоровым.
    /** @test */
    public function test_the_title_attribute_must_be_required_to_create_a_post(): void
    {
        $data = [
            'title' => '',
            'content' => 'Some very long content',
        ];

        $user = User::factory()->create();
        $res = $this->actingAs($user)->post('api/posts', $data);

        $res->assertStatus(422);      // API при ошибке отдаёт 422ой статус.
        $res->assertInvalid('title'); // чек на некорректное поле.
        $res->assertJsonValidationErrors([  // чек на конкретный errors message.
            "title" => [
                "The title field is required."
            ]
        ]);
    }

    /** @test */
    public function test_the_user_can_updated_the_post(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'title' => 'Some Title edited',
            'content' => 'Some very long content edited',
        ];

        $res = $this->actingAs($user)->put('api/posts/' . $post->id, $data);

        $res->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => $post->user_id,
                'comments_count' => $post->comments_count,
            ]
        ]);
    }

    /** @test */
    public function the_user_can_get_a_list_of_posts(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $posts = Post::factory()->count(10)
        ->create([
            'user_id' => $user->id
        ]);

        $res = $this->get('/api/posts');

        $res->assertOk();

        // мапим полученную коллекцию под формат респонса в index
        $json['data'] = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'user_id' => $post->user_id,
                'comments_count' => $post->comments_count,
                'created_at' => $post->created_at->format('Y-m-d H:m'),
                'updated_at' => $post->updated_at->format('Y-m-d H:m'),
            ];
        })->toArray();

        $res->assertJson($json); // сравниваю с полученным респонсом.
    }
}
