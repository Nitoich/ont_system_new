<?php

namespace App\Services;

class AccessTokenService
{
    protected $secret = '';
    protected $header = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];

    public function __construct()
    {
        $this->secret = config('auth.jwt_secret');
    }

    public function generate(array $payload): string {
        $base64_header = base64_encode(json_encode($this->header));
        $base64_payload = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', "$base64_header.$base64_payload", $this->secret);
        return "$base64_header.$base64_payload.$signature";
    }

    public function validate(string $token): bool {
        $token_parts = explode('.', $token);
        if(count($token_parts) !== 3) { return false; }
        $signature = hash_hmac('sha256', "$token_parts[0].$token_parts[1]", $this->secret);
        return $signature === $token_parts[2];
    }

    public function getPayload(string $token) {
        if($this->validate($token)) { return null; }
        $token_parts = explode('.', $token);
        return json_decode(base64_decode($token_parts[1]), TRUE);
    }
}
