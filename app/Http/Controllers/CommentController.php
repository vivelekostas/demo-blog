<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    public function __construct(public CommentRepository $commentRepository)
    {
        //
    }

    /**
     * @OA\Get(
     *   tags={"Comment"},
     *   path="/api/posts/{post}/comments",
     *   summary="Comment index",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/CommentResource"),
     *       )
     *     )
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @param Post $post
     *
     * @return [type]
     */
    public function index(Post $post)
    {
        return new CommentCollection($post->comments()->paginate(10));
    }

    /**
     * @OA\Post(
     *   tags={"Comment"},
     *   path="/api/posts/{post}/comment",
     *   summary="Comment store",
     *   @OA\RequestBody(
     *     required=true,
     *       @OA\JsonContent(ref="#/components/schemas/comment.storeOrUpdate")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="OK",
     *     @OA\JsonContent(ref="#/components/schemas/CommentResource")
     *   ),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     *
     * @param StoreCommentRequest $request
     *
     * @return [type]
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = $this->commentRepository->createModel($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
