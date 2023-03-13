<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Session\SafeSessionCollection;
use App\Http\Resources\Session\SafeSessionResource;
use App\Http\Resources\Session\SessionResource;
use App\Services\SessionService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SessionController extends Controller
{
    public function getSessions() {
        return response()->json(new SafeSessionCollection(Auth::user()->sessions))->setStatusCode(200);
    }

    public function refresh(
        Request $request,
        SessionService $sessionService
    ) {
        $token = $request->cookie('refresh_token');
        if(!$token) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'Не указан refresh_token'
                ]
            ])->setStatusCode(403));
        }

        if(strripos('|', $token)) {

        }
//        $token = explode('|', Crypt::decryptString($token))[1];

        $session = $sessionService->getByToken($token)->refreshToken();
        return response()
            ->json(SessionResource::make($session), 200)
            ->withCookie('refresh_token', $session->token, 43200);
    }
}
