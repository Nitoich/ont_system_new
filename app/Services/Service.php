<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Service
{
    protected $model = null;
    private \Illuminate\Database\Eloquent\Model $model_instance;
    protected string $exception_NotFoundMessage = 'Модель не найдена!';

    public function __construct()
    {
        if($this->model == null) {
            throw new \Exception('Модель не указана в сервисе!');
        }
        $this->model_instance = new $this->model();
    }

    public function getById(int $id): \Illuminate\Database\Eloquent\Model {
        $data_unit = $this->model_instance->query()->where('id', $id)->first();
        if(!$data_unit) {
            throw new HttpResponseException(response()->json($this->exception_NotFoundData())->setStatusCode(404));
        }

        return $data_unit;
    }

    public function create(array $fields): \Illuminate\Database\Eloquent\Model {
        $data_unit = new $this->model($fields);
        $data_unit->save();
        return $data_unit;
    }

    public function delete(int $id): bool {
        $data_unit = $this->getById($id);
        return $data_unit->delete();
    }

    public function update(int $id, array $fields): \Illuminate\Database\Eloquent\Model {
        $data_unit = $this->getById($id);
        $data_unit->update($fields);
        return $data_unit;
    }

    protected function exception_NotFoundData(): array {
        return [
            'error' => [
                'code' => 404,
                'message' => $this->exception_NotFoundMessage
            ]
        ];
    }
}
