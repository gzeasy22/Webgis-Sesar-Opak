<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_gempa', function (Blueprint $table) {
            $table->string('id_gempa')->primary(); // contoh: TEST-GEMPA-001
            $table->dateTime('waktu');
            $table->string('skala_mmi')->nullable(); // contoh: III
            $table->float('magnitudo');
            $table->timestamps();
        });

        // Kolom spasial (POINT) nggak ada helper bawaan Laravel,
        // jadi ditambah manual pakai raw SQL setelah tabel dibuat
        DB::statement('ALTER TABLE tb_gempa ADD geom_area POINT NOT NULL SRID 4326');
        DB::statement('CREATE SPATIAL INDEX idx_geom_area ON tb_gempa(geom_area)');
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_gempa');
    }
};