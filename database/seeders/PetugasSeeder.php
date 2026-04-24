<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Petugas Event 2',
            'email' => 'petugas2@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);
    }
}
