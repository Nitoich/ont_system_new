<?php

namespace App\Filters;


use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getFields() {
        return $this->request->all();
    }

    public function id($value) {
        return $this->builder->where('id', $value);
    }

    public function apply($builder) {
        $this->builder = $builder;
        foreach ($this->getFields() as $key => $value) {
            if(method_exists($this, $key) && $key !== 'apply' && !empty($value)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }
}
