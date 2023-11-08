<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Задаёт ответ 404 по дефолту для контроллеров API, если не найдена запрашиваемая модель.
     *
     * @param mixed $request
     * @param Throwable $e
     *
     * @return [type]
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return parent::render($request, $e);
    }
}
