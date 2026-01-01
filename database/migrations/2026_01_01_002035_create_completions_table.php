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
        Schema::create('completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Kita hubungkan ke sub_materials (Video/PDF)
            $table->foreignId('sub_material_id')->constrained('sub_materials')->onDelete('cascade');
            $table->timestamps();

            // Mencegah duplikat (Satu user cuma bisa selesaiin satu materi sekali)
            $table->unique(['user_id', 'sub_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completions');
    }
};
