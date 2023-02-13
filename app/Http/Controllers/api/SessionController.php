<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Session\SafeSessionCollection;
use App\Http\Resources\Session\SafeSessionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function getSessions() {
        return response()->json(new SafeSessionCollection(Auth::user()->sessions))->setStatusCode(200);
    }
}
