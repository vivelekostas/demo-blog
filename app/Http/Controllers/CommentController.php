<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
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
     *         @OA\Items(ref="#/components/schemas/resources.post.comments"),
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
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        //
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
