<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function __construct(public PostRepository $postRepository)
    {
        //
    }

    /**
     * @OA\Get(
     *   tags={"Post"},
     *   path="/api/posts",
     *   summary="Список",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/resources.post.index")
     *       ),
     *       @OA\Property(property="links", ref="#/components/schemas/links"),
     *       @OA\Property(property="meta", ref="#/components/schemas/meta"),
     *     )
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(): PostCollection
    {
        $page = request()->page;

        $posts = Cache::tags(['posts_index'])->rememberForever('posts:all' . $page, function () {
            return Post::paginate(10);
        });

        return new PostCollection($posts);
    }

    /**
     * @OA\Post(
     *   tags={"Post"},
     *   path="/api/posts",
     *   summary="Создание",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/post.storeOrUpdate")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", type="object",
     *         @OA\Property(property="id", type="integer", example="1", description="id поста"),
     *         @OA\Property(property="title", type="string", example="My title", description="Заголовок поста"),
     *         @OA\Property(property="content", type="string", example="Some long text", description="Тело поста"),
     *         @OA\Property(property="user_id", type="integer", example="6", description="id автора"),
     *         @OA\Property(property="comments_count", type="integer", example=null, description="кол-во комментариев"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-05 06:11", description="дата создания"),
     *         @OA\Property(property="update_at", type="string", format="date-time", example="2023-11-05 08:22", description="дата обновления")
     *       )
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     *
     * @return PostResource
     */
    public function store(StorePostRequest $request): PostResource
    {
        $post = $this->postRepository->createModel($request->validated());

        return new PostResource($post);
    }

    /**
     * @OA\Get(
     *   tags={"Post"},
     *   path="/api/posts/{post}",
     *   summary="Просмотр",
     *   @OA\Parameter(
     *     description="ID поста",
     *     in="path",
     *     name="post",
     *     required=true,
     *     example=1
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/resources.post.show"),
     *     )
     *   ),
     *   @OA\Response(response=404, description="Not Found")
     * )
     *
     * Display the specified resource.
     *
     * @param Post $post
     *
     * @return PostResource
     */
    public function show($id): PostResource
    {
        $post = Cache::get('posts:' . $id);

        return new PostResource($post);
    }

    /**
     * @OA\Put(
     *   tags={"Post"},
     *   path="/api/posts/{post}",
     *   summary="Обновление",
     *   @OA\Parameter(
     *     description="ID поста",
     *     in="path",
     *     name="post",
     *     required=true,
     *     example=1
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       allOf={
     *         @OA\Schema(
     *           @OA\Property(property="title", type="string", example="My title for update", description="Заголовок поста"),
     *           @OA\Property(property="content", type="string", example="Some long text for update", description="Тело поста"),
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", type="object",
     *         @OA\Property(property="id", type="integer", example="1", description="id поста"),
     *         @OA\Property(property="title", type="string", example="My title", description="Заголовок поста"),
     *         @OA\Property(property="content", type="string", example="Some long text", description="Тело поста"),
     *         @OA\Property(property="user_id", type="integer", example="6", description="id автора"),
     *         @OA\Property(property="comments_count", type="integer", example="0", description="кол-во комментариев"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-05 06:11", description="дата создания"),
     *         @OA\Property(property="update_at", type="string", format="date-time", example="2023-11-05 08:22", description="дата обновления")
     *       )
     *     )
     *   ),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=422, description="Unprocessable Entity")
     * )
     *
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     *
     * @return PostResource
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post = $this->postRepository->updateModel($request->validated(), $post);

        return new PostResource($post);
    }

    /**
     * @OA\Delete(
     *   tags={"Post"},
     *   path="/api/posts/{post}",
     *   summary="Удаление",
     *   @OA\Parameter(
     *     description="ID поста",
     *     in="path",
     *     name="post",
     *     required=true,
     *     example=1
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="done")
     *     )
     *   ),
     *   @OA\Response(response=404, description="Not Found")
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->postRepository->deleteModel($id);

        return response()->json(['message' => 'done']);
    }
}
