<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * @OA\Schema(
     *   schema="resources.post.index",
     *   title="Post collection",
     *   description="Post collection",
     *     @OA\Property(property="id", type="integer", example=1, description="id поста"),
     *     @OA\Property(property="title", type="string", example="My title", description="Заголовок поста"),
     *     @OA\Property(property="content", type="string", example="Some long text", description="Тело поста"),
     *     @OA\Property(property="user_id", type="integer", example=6, description="id автора"),
     *     @OA\Property(property="comments_count", type="integer", example="0", description="кол-во комментариев"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-05 06:11", description="дата создания"),
     *     @OA\Property(property="update_at", type="string", format="date-time", example="2023-11-05 08:22", description="дата обновления"),
     * )
     *
     * Transform the resource collection into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
