<?php

namespace App\Http\Controllers\Swagger;

/**
 *
 * @OA\Schema (
 *     schema="links",
 *     type="object",
 *     title="links",
 *     description="Ссылки пагинации",
 *       @OA\Property(
 *         property="first",
 *         type="string",
 *         example="http://127.0.0.1/api/posts?page=1",
 *         description="url первой страницы"
 *       ),
 *       @OA\Property(
 *         property="last",
 *         type="string",
 *         example="http://127.0.0.1/api/posts?page=2",
 *         description="url последней страницы"
 *       ),
 *       @OA\Property(
 *         property="prev",
 *         type="string",
 *         example=null,
 *         description="url предыдущей страницы"
 *       ),
 *       @OA\Property(
 *         property="next",
 *         type="string",
 *         example="http://127.0.0.1/api/posts?page=2",
 *         description="url следующей страницы"
 *       )
 * )
 *
 *
 * [Description LinksSchema]
 */
class LinksSchema
{
    //
}
