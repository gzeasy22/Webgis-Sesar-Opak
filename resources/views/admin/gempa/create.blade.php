@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 20px auto; font-family: sans-serif;">
    <h2>Tambah Data Gempa</h2>

    @if($errors->any())
        <ul style="color:red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.gempa.store') }}" method="POST">
        @csrf
        <label>ID Gempa</label><br>
        <input type="text" name="id_gempa" placeholder="GEMPA-006" required style="width:100%; margin-bottom:10px;"><br>

        <label>Waktu</label><br>
        <input type="datetime-local" name="waktu" required style="width:100%; margin-bottom:10px;"><br>

        <label>Skala MMI</label><br>
        <input type="text" name="skala_mmi" placeholder="III" style="width:100%; margin-bottom:10px;"><br>

        <label>Magnitudo</label><br>
        <input type="number" step="0.1" name="magnitudo" required style="width:100%; margin-bottom:10px;"><br>

        <label>Latitude</label><br>
        <input type="number" step="0.000001" name="latitude" required style="width:100%; margin-bottom:10px;"><br>

        <label>Longitude</label><br>
        <input type="number" step="0.000001" name="longitude" required style="width:100%; margin-bottom:10px;"><br>

        <button type="submit" style="padding:8px 16px; background:#2563eb; color:white; border:none; border-radius:4px;">Simpan</button>
    </form>
</div>
@endsection