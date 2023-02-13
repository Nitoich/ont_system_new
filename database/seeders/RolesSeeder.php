<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role([
            'name' => 'Администратор',
            'slug' => 'admin'
        ]);
        $role->save();
        $role->permissions()->saveMany(Permission::all());

        $role = new Role([
            'name' => 'Пользователь',
            'slug' => 'user'
        ]);
        $role->save();
        $role->permissions()->saveMany(Permission::query()
            ->orWhere('slug', 'read_self_sessions')
            ->get()
        );
    }
}
