<?php

namespace App\Http\Controllers\api;

use App\Filters\UsersFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe() {
        return response()->json(UserResource::make(Auth::user()))->setStatusCode(200);
    }

    public function getRoles(
        int $id
    ) {
        return response()->json(Auth::user()->roles);
    }

    public function index(
        UsersFilter $filter
    ) {
        $users = User::query()->filter($filter)->paginate(10);
        return response()->json(UserResource::collection($users)->response()->getData(true))->setStatusCode(200);
    }
}
