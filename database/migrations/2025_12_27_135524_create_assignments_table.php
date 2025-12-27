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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            // Menempel ke Material (Bab), BUKAN Course
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Judul Tugas
            $table->text('instruction')->nullable(); // Instruksi soal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
