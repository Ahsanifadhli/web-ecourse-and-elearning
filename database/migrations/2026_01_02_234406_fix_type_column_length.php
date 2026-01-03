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
        // Paksa ubah kolom type jadi VARCHAR(255)
        DB::statement("ALTER TABLE sub_materials MODIFY COLUMN type VARCHAR(255) DEFAULT 'file'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
