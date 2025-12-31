<?php

namespace Database\Seeders;

use App\Models\rekam_medis;
use Illuminate\Database\Seeder;

class RekamMedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        rekam_medis::factory(20)->create();
    }
}
