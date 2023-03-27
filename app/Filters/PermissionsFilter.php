<?php

namespace App\Filters;

use App\Models\User;

class PermissionsFilter extends SlugAndNameFilter
{
    public function user_id($value): void
    {
        $this->builder
            ->whereHas('users', function ($builder) use ($value) {
                $builder->where('id', $value);
            });
    }

    public function role_id($value): void
    {
        $this->builder
            ->whereHas('roles', function ($builder) use ($value) {
                $builder->where('id', $value);
            });
    }
}
