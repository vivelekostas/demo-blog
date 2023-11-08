<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *   schema="post.storeOrUpdate",
 *   title="postStore",
 *   required={"title", "content"},
 *
 *     @OA\Property(property="title", type="string", example="My title", description="Заголовок поста"),
 *     @OA\Property(property="content", type="string", example="Some long text", description="Тело поста")
 * )
 */
class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:250',
            'content' => 'required|string',
            'user_id' => 'required|integer',
        ];
    }
}
