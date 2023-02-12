<?php

namespace App\Services;

use App\Models\Session;
use Illuminate\Support\Str;

class SessionService
{
    public function create(array $fields): Session {
        $session = new Session($fields);
        $session->token = Str::random(128);
        $session->expire_date = new \DateTime('now +1 month');
        $session->save();
        return $session;
    }
}
