<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GempaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 'GEMPA-001', 'waktu' => '2024-01-15 08:23:00', 'mmi' => 'II', 'mag' => 2.8, 'lon' => 110.4203, 'lat' => -7.8631],
            ['id' => 'GEMPA-002', 'waktu' => '2024-02-03 14:11:00', 'mmi' => 'III', 'mag' => 3.4, 'lon' => 110.4512, 'lat' => -7.8892],
            ['id' => 'GEMPA-003', 'waktu' => '2024-03-10 21:47:00', 'mmi' => 'IV', 'mag' => 4.1, 'lon' => 110.3987, 'lat' => -7.8455],
            ['id' => 'GEMPA-004', 'waktu' => '2024-04-22 03:05:00', 'mmi' => 'II', 'mag' => 2.5, 'lon' => 110.4321, 'lat' => -7.8703],
            ['id' => 'GEMPA-005', 'waktu' => '2024-05-30 16:38:00', 'mmi' => 'V', 'mag' => 5.0, 'lon' => 110.4156, 'lat' => -7.8567],
        ];

        foreach ($data as $row) {
            DB::insert(
                "INSERT INTO tb_gempa (id_gempa, waktu, skala_mmi, magnitudo, geom_area, created_at, updated_at)
                VALUES (?, ?, ?, ?, ST_GeomFromText(?, 4326, 'axis-order=long-lat'), NOW(), NOW())",
                [$row['id'], $row['waktu'], $row['mmi'], $row['mag'], "POINT({$row['lon']} {$row['lat']})"]
            );
        }
    }
}