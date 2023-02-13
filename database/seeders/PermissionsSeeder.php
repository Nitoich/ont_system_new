<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return array
     */
    private function permission(string $name, $slug = null): array {
        return [
            'name' => $name,
            'slug' => $slug ?? Str::slug($name)
        ];
    }

    public function run()
    {
        Permission::query()
            ->insert([
                $this->permission('Получение своих сессий', 'read_self_sessions'),
                $this->permission('Удаление своих сессий', 'delete_self_sessions'),
            ]);
    }
}
