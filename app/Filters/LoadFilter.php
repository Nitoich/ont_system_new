<?php

namespace App\Filters;

class LoadFilter extends QueryFilter
{
    public function discipline_id($value) {
        $this->builder->where('discipline_id', $value);
    }

    public function group_id($value) {
        $this->builder->where('group_id', $value);
    }

    public function semester_id($value) {
        $this->builder->where('semester_id', $value);
    }

    public function user_id($value) {
        $this->builder->where('user_id', $value);
    }

    public function type($value) {
        $this->builder->where('type', $value);
    }
}
