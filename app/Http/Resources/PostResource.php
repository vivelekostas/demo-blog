<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * @OA\Schema(
     *   schema="resources.post.show",
     *   title="Post resources",
     *   description="Post resources",
     *     @OA\Property(property="id", type="integer", example=1, description="id поста"),
     *     @OA\Property(property="title", type="string", example="My title", description="Заголовок поста"),
     *     @OA\Property(property="content", type="string", example="Some long text", description="Тело поста"),
     *     @OA\Property(property="user_id", type="integer", example=6, description="id автора"),
     *     @OA\Property(property="comments_count", type="integer", example="0", description="кол-во комментариев"),
     *     @OA\Property(
     *       property="comments",
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/CommentResource")
     *     ),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-05 06:11", description="дата создания"),
     *     @OA\Property(property="update_at", type="string", format="date-time", example="2023-11-05 08:22", description="дата обновления"),
     * )
     *
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'comments_count' => $this->comments_count,
            'comments' => $this->when($request->routeIs('posts.show'), function () {
                return $this->comments;
            }),
            'created_at' => $this->created_at->format('Y-m-d H:m'),
            'updated_at' => $this->updated_at->format('Y-m-d H:m'),
        ];
    }
}
