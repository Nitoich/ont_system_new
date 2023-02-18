<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'email' => 'admin@admin',
            'password' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'surname' => 'admin',
            'birth_day' => '1970-01-01',
        ]);
        $user->save();
        $user->roles()->save(Role::query()->where('slug', 'admin')->first());
    }
}
