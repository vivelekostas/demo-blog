<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Schema (
 *     schema="meta",
 *     type="object",
 *     title="meta",
 *     description="Meta информация пагинации",
 *
 *     @OA\Property(property="current_page", type="integer", title="Номер текущей страницы", example=1),
 *     @OA\Property(property="from", type="integer", title="От (порядковый номер сущности)", example=1),
 *     @OA\Property(property="last_page", type="integer", title="Номер последней страницы", example=2),
 *     @OA\Property(
 *         property="links",
 *         type="array",
 *         title="Массив ссылок пагинатора",
 *         @OA\Items(
 *             @OA\Property(property="url", type="string", title="url страницы", example= "http://127.0.0.1/api/posts?page=1"),
 *             @OA\Property(property="label", type="string", title="title ссылки", example="1"),
 *             @OA\Property(property="active", type="boolean", title="доступность ссылки", example=true),
 *         )
 *     ),
 *     @OA\Property(property="path", type="string", title="Основной путь запроса", example="http://127.0.0.1/api/posts"),
 *     @OA\Property(property="per_page", type="integer", title="Кол-во выводимых сущностей", example=10),
 *     @OA\Property(property="to", type="integer", title="До (порядковый номер сущности)", example=10),
 *     @OA\Property(property="total", type="integer", title="Всего сущностей", example=18),
 * )
 *
 * [Description MetaSchema]
 */
class MetaSchema
{
    //
}
