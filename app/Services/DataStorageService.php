<?php

namespace App\Services;

use App\Models\Utils\DataStorage;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataStorageService extends Service
{
    protected $model = DataStorage::class;

    public function getByKey(string $key): DataStorage
    {
        return DataStorage::query()->where('key', $key)->firstOr(function () {
            throw new HttpResponseException(response()->json($this->exception_NotFoundData())->setStatusCode(404));
        });
    }
}
