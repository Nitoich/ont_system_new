<?php

namespace App\Models;

use App\Services\AccessTokenService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'device_name',
        'user_id'
    ];

    public function getAccessTokenAttribute(): string {
        return (new AccessTokenService())->generate([
            'token_id' => $this->attributes['id'],
            'user_id' => $this->attributes['user_id'],
            'iat' => strtotime((new \DateTime('now'))->format('Y-m-d H:i:s')),
            'exp' => strtotime((new \DateTime('now +5 minutes'))->format('Y-m-d H:i:s'))
        ]);
    }
}
