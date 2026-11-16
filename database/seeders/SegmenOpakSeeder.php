<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegmenOpakSeeder extends Seeder
{
    public function run(): void
    {
        $wkt = "LINESTRING(110.27667647445355 -8.024949219965336, 110.29961655295678 -8.004626126791662, 110.31697104052373 -7.9916970373689775, 110.3343244628611 -7.978767119200828, 110.3454811430689 -7.969529005089, 110.37641708855 -7.941728, 110.40088 -7.914728, 110.41978 -7.891728, 110.43428 -7.868728, 110.44528 -7.848728, 110.45228 -7.828728, 110.45478 -7.808728, 110.45228 -7.788728, 110.44528 -7.770014753565677)";

        DB::insert(
            "INSERT INTO tb_segmen (nama_segmen, deskripsi, geom_line, created_at, updated_at)
             VALUES (?, ?, ST_GeomFromText(?, 4326, 'axis-order=long-lat'), NOW(), NOW())",
            ['Sesar Opak', 'Panjang 47 km, magnitudo maksimum (Mmax) 6.9, tipe strike-slip. Sumber: PuSGeN.', $wkt]
        );

        $this->command->info("Berhasil insert garis Sesar Opak.");
    }
}