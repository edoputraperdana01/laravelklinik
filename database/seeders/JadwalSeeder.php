<?php

namespace Database\Seeders;

use App\Models\jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        jadwal::factory(10)->create();
    }
}
