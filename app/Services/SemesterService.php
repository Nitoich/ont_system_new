<?php

namespace App\Services;

use App\Models\Semester;

class SemesterService extends Service
{
    protected $model = Semester::class;

    public function getCurrentSemester(): ?Semester
    {
        return Semester::where('active', true)->first();
    }
}
