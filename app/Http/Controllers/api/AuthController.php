<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Resources\Session\SessionResource;
use App\Models\User;
use App\Services\SessionService;
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        UserService $userService,
        SessionService $sessionService
    ): \Illuminate\Http\JsonResponse
    {
        $user = $userService->create($request->all());
        $session = $sessionService->create([
            'user_id' => $user->id,
            'device_name' => $request->device_name
        ]);
        return response()
            ->json(SessionResource::make($session), 201)
            ->withCookie('refresh_token', $session->token, 43200);
    }

    public function login(
        LoginRequest $request,
        UserService $userService,
        SessionService $sessionService
    ) {
        $user = $userService->getByEmail($request->email);
        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Не правильный пароль!'
                ]
            ], 401);
        }
        $session = $sessionService->create([
            'user_id' => $user->id,
            'device_name' => $request->device_name
        ]);
        return response()
            ->json(SessionResource::make($session), 200)
            ->withCookie('refresh_token', $session->token, 43200);

    }

    public function logout(
        SessionService $sessionService,
        Request $request
    ) {
        $token = $request->cookie('refresh_token');
        if(!$token) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 400,
                    'message' => 'Не указан refresh_token'
                ]
            ])->setStatusCode(400));
        }

        $session = $sessionService->getByToken($token);
        $session->delete();

        $cookie = Cookie::forget('refresh_token');
        return response()->json()->setStatusCode(200)->withCookie($cookie);
    }
}
