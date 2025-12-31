<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_pasien' => $this->faker->name(),
            'user_id' => $this->faker->numberBetween(0, User::count()),
            'tgl_reservasi' => $this->faker->date('Y_m_d'),
            'keluhan' => $this->faker->word(),
            'no_antrian' => $this->faker->numberBetween(0, 20),
            'status_hadir' => $this->faker->numberBetween(0, 1)
        ];
    }
}
