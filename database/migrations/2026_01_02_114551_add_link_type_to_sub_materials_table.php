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
        Schema::table('sub_materials', function (Blueprint $table) {

            // 1. CEK DULU: Kalau kolom 'type' BELUM ada, baru buat.
            if (!Schema::hasColumn('sub_materials', 'type')) {
                $table->string('type')->default('file')->after('title');
            }

            // 2. CEK DULU: Kalau kolom 'link' BELUM ada, baru buat.
            if (!Schema::hasColumn('sub_materials', 'link')) {
                $table->string('link')->nullable()->after('file_path');
            }

            // 3. Ubah file_path jadi nullable (boleh kosong)
            // Pastikan install doctrine/dbal kalau error di sini, tapi coba dulu aja
            $table->string('file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_materials', function (Blueprint $table) {
            //
        });
    }
};
