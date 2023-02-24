<?php

namespace Database\Seeders;

use App\Models\Load;
use Illuminate\Database\Seeder;

class LoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Load::factory(15)->create();
    }
}
