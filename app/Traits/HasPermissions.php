<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

trait HasPermissions
{
    public function hasPermission(Permission $permission): bool {
        return $this->permissions->contains('slug', $permission->slug);
    }

    public function givePermission(Permission $permission) {
        $this->permissions()->save($permission);
        return $this;
    }

    public function removePermission(Permission $permission) {
        $this->permissions()->detach($permission);
        return $this;
    }
}
