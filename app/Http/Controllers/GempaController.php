<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GempaController extends Controller
{
    public function index()
    {
        // Ambil data gempa dari database
        // Koordinat geometry dibaca sebagai:
        // X = longitude
        // Y = latitude
        $data = DB::table('tb_gempa')
            ->select(
                'id_gempa',
                'waktu',
                'skala_mmi',
                'magnitudo',

                // Menyesuaikan hasil geometry yang saat ini
                // terbaca terbalik pada endpoint API
                DB::raw('ST_X(geom_area) as latitude'),
                DB::raw('ST_Y(geom_area) as longitude')
            )
            ->get();

        return response()->json($data);
    }
}