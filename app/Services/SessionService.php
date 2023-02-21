<?php

namespace App\Services;

use App\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class SessionService extends Service
{
    protected $model = Session::class;
    public function create(array $fields): Model {
        $session = new Session($fields);
        $session->token = Str::random(128);
        $session->expire_date = new \DateTime('now +1 month');
        $session->save();
        return $session;
    }

    public function getByToken(string $token) {
        $session = Session::query()
            ->where('token', $token)
            ->first();

        if(!$session) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Сессии с таким токеном не существует!'
                ]
            ])->setStatusCode(404));
        }

        return $session;
    }
}
