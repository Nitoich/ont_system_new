<?php

namespace App\Models;

use App\Traits\CanBeFiltered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory, CanBeFiltered;

    protected $fillable = [
        'name',
        'slug',
        'speciality_id'
    ];

    public function speciality() {
        return $this->belongsTo(Speciality::class, 'id', 'speciality_id');
    }
}
