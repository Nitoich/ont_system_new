<?php

namespace App\Models;

use App\Traits\CanBeFiltered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ПРАВА НЕ ДОДЕЛАНЫ, ВСЕ В ОСНОВНОМ ПРИВЯЗАВНО К РОЛЯМ
class Permission extends Model
{
    use HasFactory, CanBeFiltered;

    public function users() {
        return $this->belongsToMany(User::class, 'users_permissions');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
