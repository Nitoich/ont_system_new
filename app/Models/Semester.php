<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start',
        'date_end'
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute(): string {
        $dateTime_start = new \DateTime($this->date_start);
        $dateTime_end = new \DateTime($this->date_end);
        return "{$dateTime_start->format('d.m.Y')} - {$dateTime_end->format('d.m.Y')}";
    }
}
