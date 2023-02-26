<?php

namespace App\Filters;

class UsersFilter extends QueryFilter
{
    public function email($value) {
        $this->builder->where('email', 'like', "$value%");
    }

    public function first_name($value) {
        $this->builder->where('first_name', 'like', "$value%");
    }

    public function last_name($value) {
        $this->builder->where('last_name', 'like', "$value%");
    }

    public function surname($value) {
        $this->builder->where('surname', 'like', "$value%");
    }

    public function role_id($value) {
        $this->builder->whereHas('roles', function ($builder) use ($value) {
            $builder->where('id', $value);
        });
    }
}
