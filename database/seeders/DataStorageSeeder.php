<?php

namespace Database\Seeders;

use App\Models\Utils\DataStorage;
use Illuminate\Database\Seeder;

class DataStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataStorage::query()
            ->create([
                "key" => "admin_left_menu_accesses",
                "value" => [
                    'users' => ['admin'],
                    'loads' => ['admin', 'teacher'],
                    'groups' => ['admin'],
                    'discipline' => ['admin'],
                    'roles' => ['admin']
                ]
            ]);
    }
}
