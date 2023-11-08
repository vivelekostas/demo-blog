<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/api/login",
     *   summary="Логин",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       allOf={
     *         @OA\Schema(
     *           @OA\Property(
     *             property="email",
     *             type="string",
     *             example="ololo@gmail.com",
     *             description="логин"
     *           ),
     *           @OA\Property(
     *             property="password",
     *             type="string",
     *             example="12345Pic",
     *             description="пароль"
     *           )
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(response=204, description="No Content"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     *
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
