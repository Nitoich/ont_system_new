<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createTestUser(string $role_slug = 'user'): array {
        $user = User::factory()->create();
        $user->roles()->save(Role::query()->where('slug', $role_slug)->first());
        $user_session = $user->createSession();
        return [
            'user' => $user,
            'session' => $user_session
        ];
    }

    public function getAccessNewUser(string $role_slug = 'user'): string {
        $user = $this->createTestUser($role_slug);
        return $user['session']->access_token;
    }

    public function withAccess(string $role_slug = 'user'): TestCase {
        return $this->withToken($this->getAccessNewUser($role_slug));
    }
}
