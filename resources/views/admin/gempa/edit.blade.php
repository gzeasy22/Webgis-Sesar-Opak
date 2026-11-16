@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 20px auto; font-family: sans-serif;">
    <h2>Edit Data Gempa</h2>

    <form action="{{ route('admin.gempa.update', $gempa->id_gempa) }}" method="POST">
        @csrf @method('PUT')

        <label>ID Gempa</label><br>
        <input type="text" value="{{ $gempa->id_gempa }}" disabled style="width:100%; margin-bottom:10px; background:#eee;"><br>

        <label>Waktu</label><br>
        <input type="datetime-local" name="waktu" value="{{ \Carbon\Carbon::parse($gempa->waktu)->format('Y-m-d\TH:i') }}" required style="width:100%; margin-bottom:10px;"><br>

        <label>Skala MMI</label><br>
        <input type="text" name="skala_mmi" value="{{ $gempa->skala_mmi }}" style="width:100%; margin-bottom:10px;"><br>

        <label>Magnitudo</label><br>
        <input type="number" step="0.1" name="magnitudo" value="{{ $gempa->magnitudo }}" required style="width:100%; margin-bottom:10px;"><br>

        <label>Latitude</label><br>
        <input type="number" step="0.000001" name="latitude" value="{{ $gempa->latitude }}" required style="width:100%; margin-bottom:10px;"><br>

        <label>Longitude</label><br>
        <input type="number" step="0.000001" name="longitude" value="{{ $gempa->longitude }}" required style="width:100%; margin-bottom:10px;"><br>

        <button type="submit" style="padding:8px 16px; background:#2563eb; color:white; border:none; border-radius:4px;">Update</button>
    </form>
</div>
@endsection