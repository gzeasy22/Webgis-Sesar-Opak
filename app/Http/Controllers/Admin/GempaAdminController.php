<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GempaAdminController extends Controller
{
    // Tampilkan daftar semua data gempa
    public function index()
    {
        $gempa = DB::table('tb_gempa')
            ->select(
                'id_gempa', 'waktu', 'skala_mmi', 'magnitudo',
                DB::raw('ST_Y(geom_area) as latitude'),
                DB::raw('ST_X(geom_area) as longitude')
            )
            ->orderBy('waktu', 'desc')
            ->get();

        return view('admin.gempa.index', compact('gempa'));
    }

    // Tampilkan form tambah data baru
    public function create()
    {
        return view('admin.gempa.create');
    }

    // Simpan data baru dari form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_gempa'   => 'required|string|max:255|unique:tb_gempa,id_gempa',
            'waktu'      => 'required|date',
            'skala_mmi'  => 'nullable|string|max:10',
            'magnitudo'  => 'required|numeric|min:0|max:10',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        DB::insert(
            "INSERT INTO tb_gempa (id_gempa, waktu, skala_mmi, magnitudo, geom_area, created_at, updated_at)
             VALUES (?, ?, ?, ?, ST_GeomFromText(?, 4326, 'axis-order=long-lat'), NOW(), NOW())",
            [
                $validated['id_gempa'],
                $validated['waktu'],
                $validated['skala_mmi'],
                $validated['magnitudo'],
                "POINT({$validated['longitude']} {$validated['latitude']})"
            ]
        );

        return redirect()->route('admin.gempa.index')->with('success', 'Data gempa berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $gempa = DB::table('tb_gempa')
            ->select(
                'id_gempa', 'waktu', 'skala_mmi', 'magnitudo',
                DB::raw('ST_Y(geom_area) as latitude'),
                DB::raw('ST_X(geom_area) as longitude')
            )
            ->where('id_gempa', $id)
            ->firstOrFail();

        return view('admin.gempa.edit', compact('gempa'));
    }

    // Update data dari form edit
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'waktu'      => 'required|date',
            'skala_mmi'  => 'nullable|string|max:10',
            'magnitudo'  => 'required|numeric|min:0|max:10',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
        ]);

        DB::update(
            "UPDATE tb_gempa SET waktu = ?, skala_mmi = ?, magnitudo = ?,
             geom_area = ST_GeomFromText(?, 4326, 'axis-order=long-lat'), updated_at = NOW()
             WHERE id_gempa = ?",
            [
                $validated['waktu'],
                $validated['skala_mmi'],
                $validated['magnitudo'],
                "POINT({$validated['longitude']} {$validated['latitude']})",
                $id
            ]
        );

        return redirect()->route('admin.gempa.index')->with('success', 'Data gempa berhasil diupdate.');
    }

    // Hapus data
    public function destroy($id)
    {
        DB::table('tb_gempa')->where('id_gempa', $id)->delete();
        return redirect()->route('admin.gempa.index')->with('success', 'Data gempa berhasil dihapus.');
    }
}