<?php

namespace Database\Seeders;

use App\Models\reservasi;
use Illuminate\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        reservasi::factory(10)->create();
    }
}
