<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proofreading extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'group_id',
        'user_id',
        'discipline_id',
        'hours'
    ];

    public function group(): HasOne
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function discipline(): HasOne
    {
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }
}
