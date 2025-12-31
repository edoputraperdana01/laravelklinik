<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'bintang',
            'level' => '1',
            'birthday' => '2022-10-10',
            'address' => 'tarik',
            'telp' => '081234567',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);
        User::create([
            'name' => 'bintang',
            'level' => '2',
            'birthday' => '2022-10-10',
            'address' => 'tarik',
            'telp' => '081234567',
            'email' => 'doctor@doctor.com',
            'password' => bcrypt('12345678')
        ]);
        // User::factory(10)->create();
    }
}
