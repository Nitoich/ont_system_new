<?php

namespace App\Services;

use App\Models\Load;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoadService extends Service
{
    private SemesterService $semesterService;
    public function __construct(SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    protected $model = Load::class;

    public function create(array $fields): \Illuminate\Database\Eloquent\Model
    {
        $modify_fields = $fields;

        if(empty($fields['semester_id'])) {
            $semester = $this->semesterService->getCurrentSemester();
            if(!$semester) {
                throw new HttpResponseException(response()->json([
                    'error' => [
                        'code' => 422,
                        'message' => 'Validation error',
                        'errors' => [
                            'semester_id' => ['Активного семестра нет, требуется указать семетр явно!']
                        ]
                    ]
                ])->setStatusCode(422));
            } else {
                $modify_fields['semester_id'] = $semester->id;
            }
        }
        return parent::create($modify_fields); // TODO: Change the autogenerated stub
    }
}
