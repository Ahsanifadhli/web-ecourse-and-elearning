<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@lms.com', // <--- WAJIB DITAMBAHKAN
            'role' => 'admin',
            'password' => Hash::make('admin1234'),
        ]);

        // 2. Buat Akun PESERTA
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@gmail.com', // <--- WAJIB DITAMBAHKAN
            'role' => 'student',
            'password' => Hash::make('murid1234'),
        ]);
    }
}
