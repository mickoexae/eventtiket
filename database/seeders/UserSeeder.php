<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data Admin
        User::create([
            'nama'     => 'micko',
            'email'    => 'micko@gmail.com',
            'password' => Hash::make('micko123'),
            'role'     => 'admin', // Sesuai Tugas 4 & 28
        ]);

        // Data User/Pelanggan
        User::create([
            'nama'     => 'indra',
            'email'    => 'indra@gmail.com',
            'password' => Hash::make('indra123'),
            'role'     => 'user', // Sesuai Tugas 4 & 28
        ]);

        User::create([
            'nama' => 'putra',
            'email' => 'putra@gmail.com',
            'password' => Hash::make('putra123'),
            'role' => 'petugas',
        ]);
    }
}