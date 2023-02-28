<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService extends Service
{
    protected $model = User::class;

    public function create(array $fields): User {
        $user = new User($fields);
        $user->save();
        $user->roles()->save(Role::query()->where('slug', 'user')->first());
        return $user;
    }

    public function getByEmail(string $email): User {
        $user = User::query()
            ->where('email', $email)
            ->first();
        if(!$user) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Пользователь не найден!'
                ]
            ], 404));
        }
        return $user;
    }
}
