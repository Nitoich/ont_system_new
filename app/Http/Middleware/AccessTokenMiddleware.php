<?php

namespace App\Http\Middleware;

use App\Services\AccessTokenService;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessTokenService = new AccessTokenService();
        $userService = new UserService();
        $token = $request->bearerToken();
        if(!$token || !$accessTokenService->validate($token)) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Не авторизован!'
                ]
            ])->setStatusCode(401));
        }
        $payload = $accessTokenService->getPayload($token);
        Auth::login($userService->getById($payload['user_id']));
        return $next($request);
    }
}
