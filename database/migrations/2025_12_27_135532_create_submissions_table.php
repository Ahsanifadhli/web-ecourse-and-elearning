<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            // Pengumpulan milik Tugas mana?
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            // Siapa yang mengumpulkan?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // File jawabannya
            $table->string('file_path');
            // Nilai (Opsional, diisi nanti sama Admin)
            $table->integer('grade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
