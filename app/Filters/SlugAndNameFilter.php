<?php

namespace App\Filters;

class SlugAndNameFilter extends QueryFilter
{
    public function name($value) {
        $this->builder->where('name', 'like', "$value%");
    }

    public function slug($value) {
        $this->builder->where('slug', 'like', "$value%");
    }
}
