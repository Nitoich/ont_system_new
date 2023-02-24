<?php

namespace App\Models;

use App\Traits\CanBeFiltered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory, CanBeFiltered;

    protected $fillable = [
        'semester_id',
        'group_id',
        'discipline_id',
        'type',
        'characteristic',
        'hours'
    ];

    public function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function discipline() {
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }
}
