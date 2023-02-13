<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()
            ->insert([
                [
                    'name' => 'Permission',
                    'slug' => '123'
                ]
            ]);
    }
}
