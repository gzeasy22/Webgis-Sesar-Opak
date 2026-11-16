<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GempaOpakSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan dulu data dummy lama
        DB::table('tb_gempa')->truncate();

        $file = fopen(database_path('seeders/data/gempa_sesar_opak.csv'), 'r');
        $header = fgetcsv($file); // lewati baris header

        $batch = [];
        $count = 0;

        while (($row = fgetcsv($file)) !== false) {
            [$id, $waktu, $magnitudo, $kedalaman, $lat, $lon] = $row;

            DB::insert(
                "INSERT INTO tb_gempa (id_gempa, waktu, skala_mmi, magnitudo, geom_area, created_at, updated_at)
                 VALUES (?, ?, NULL, ?, ST_GeomFromText(?, 4326, 'axis-order=long-lat'), NOW(), NOW())",
                [$id, $waktu, $magnitudo, "POINT({$lon} {$lat})"]
            );

            $count++;
        }
        fclose($file);

        $this->command->info("Berhasil insert {$count} data gempa asli.");
    }
}