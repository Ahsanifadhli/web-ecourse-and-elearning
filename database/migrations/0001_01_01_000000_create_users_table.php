<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // KITA BUTUH KEDUANYA:
            $table->string('username')->unique(); // Buat login manual (budi123)
            $table->string('email')->unique();    // WAJIB ADA buat Google Login (budi@gmail.com)

            // Password dibuat nullable (boleh kosong) jaga-jaga kalau login sosmed
            $table->string('password')->nullable();

            // Kolom tambahan untuk Google
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();

            $table->enum('role', ['admin', 'student'])->default('student');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
