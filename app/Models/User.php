<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Filters\UsersFilter;
use App\Services\SessionService;
use App\Traits\CanBeFiltered;
use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions, CanBeFiltered;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'surname',
        'birth_day'
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function createSession(): Session {
        $sessionService = new SessionService();
        return $sessionService->create([
            'user_id' => $this->id,
            'device_name' => 'GENERATED'
        ]);
    }

    public function sessions() {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function hasRole(Role ...$roles): bool {
        foreach ($roles as $role) {
            if($this->roles->contains('slug', $role->slug)) {
                return true;
            }
        }
        return false;
    }

    public function hasRoleBySlug(...$slugs): bool {
        $queryBuilder = Role::query();
        foreach ($slugs as $slug) {
            $queryBuilder->orWhere($slug);
        }
        $roles = $queryBuilder->get();
        return $this->hasRole($roles);
    }

    public function hasPermissionThroughRole(Permission $permission): bool {
        $user_roles = $this->roles;
        foreach ($user_roles as $role) {
            if($role->permissions->contains('slug', $permission->slug)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo(Permission $permission): bool
    {
        return $this->hasPermission($permission) || $this->hasPermissionThroughRole($permission);
    }
}
