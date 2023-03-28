<?php

namespace App\Models\Utils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStorage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value'
    ];

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = serialize($value);
    }

    public function getValueAttribute()
    {
        return unserialize($this->attributes['value']);
    }
}
