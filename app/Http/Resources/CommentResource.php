<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * @OA\Schema(
     *   schema="CommentResource",
     *   title="Post Comment",
     *   description="Post Comment",
     *     @OA\Property(property="id", type="integer", example="1", description="id комментария"),
     *     @OA\Property(property="text", type="string", example="какой-то комментарий", description="Тело комментария"),
     *     @OA\Property(property="user_id", type="integer", example=6, description="id автора"),
     *     @OA\Property(property="post_id", type="integer", example=3, description="id поста"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-05 06:11", description="дата создания"),
     *     @OA\Property(property="update_at", type="string", format="date-time", example="2023-11-05 08:22", description="дата обновления"),
     * )
     *
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user_id' => $this->user_id,
            'post_id' => $this->post_id,
            'created_at' => $this->created_at->format('Y-m-d H:m'),
            'updated_at' => $this->updated_at->format('Y-m-d H:m'),
        ];
    }
}
