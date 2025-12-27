<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // baris ini biarkan komentar atau hapus
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
            'username' => 'admin', // Username untuk login
            'role' => 'admin',
            'password' => Hash::make('admin1234'), // Passwordnya: admin1234
        ]);

        // 2. Buat Akun PESERTA (untuk tes tampilan siswa)
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi', // Username untuk login
            'role' => 'student',
            'password' => Hash::make('murid1234'), // Passwordnya: murid1234
        ]);
    }
}
