<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tgl_jadwal' => $this->faker->date(),
            'jam_masuk' => $this->faker->time(),
            'jam_pulang' => $this->faker->time(),
            'status_masuk' => $this->faker->numberBetween(0, 1),
            'jumlah_maxpasien' => $this->faker->numberBetween(0, 20),
            'jumlah_pasien_hari_ini' => $this->faker->numberBetween(0, 20)
        ];
    }
}
