<?php

namespace App\Models\Utils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStorage extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];
}
