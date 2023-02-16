<?php

namespace App\Traits;

use App\Filters\QueryFilter;

trait CanBeFiltered
{
    public function scopeFilter($builder, QueryFilter $filter) {
        return $filter->apply($builder);
    }
}
