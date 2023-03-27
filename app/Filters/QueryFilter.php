<?php

namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Builder $builder;
    protected Request $request;
    protected array $exception_methods = [];

    public function __construct(Request $request)
    {
        $this->exception_methods[] = 'apply';
        $this->request = $request;
    }

    protected function getFields(): array
    {
        return $this->request->all();
    }

    public function id($value): void
    {
        $this->builder->where('id', $value);
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->getFields() as $key => $value) {
            if(method_exists($this, $key) && !in_array($key, $this->exception_methods) && !empty($value)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }
}
