<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class Rekam_MedisFactory extends Factory
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
            'User_id' => $this->faker->numberBetween(0, User::count()),
            'nama_penyakit' => $this->faker->word(),
            'kadar_gula_darah' => $this->faker->numberBetween(0, 100),
            'kadar_kolesterol' => $this->faker->numberBetween(0, 100),
            'kadar_asam_urat' => $this->faker->numberBetween(0, 100),
            'tekanan_darah' => $this->faker->numberBetween(0, 100),
            'alergi_makanan' => $this->faker->word(1),
            'tgl_periksa' => $this->faker->date('Y_m_d'),
            'usia' => $this->faker->numberBetween(0, 100),
            'keterangan' => $this->faker->word()
        ];
    }
}
