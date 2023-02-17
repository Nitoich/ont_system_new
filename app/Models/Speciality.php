<?php

namespace App\Models;

use App\Traits\CanBeFiltered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory, CanBeFiltered;

    protected $fillable = [
        'name',
        'slug'
    ];
}
