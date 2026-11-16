@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 20px auto; font-family: sans-serif;">
    <h2>Data Gempa</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.gempa.create') }}" style="display:inline-block; margin-bottom:10px; padding:8px 12px; background:#2563eb; color:white; text-decoration:none; border-radius:4px;">
        + Tambah Data Gempa
    </a>

    <table border="1" cellpadding="8" style="width:100%; border-collapse: collapse;">
        <thead style="background:#f3f4f6;">
            <tr>
                <th>ID</th><th>Waktu</th><th>MMI</th><th>Magnitudo</th><th>Lat</th><th>Lon</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gempa as $g)
            <tr>
                <td>{{ $g->id_gempa }}</td>
                <td>{{ $g->waktu }}</td>
                <td>{{ $g->skala_mmi }}</td>
                <td>{{ $g->magnitudo }}</td>
                <td>{{ $g->latitude }}</td>
                <td>{{ $g->longitude }}</td>
                <td>
                    <a href="{{ route('admin.gempa.edit', $g->id_gempa) }}">Edit</a> |
                    <form action="{{ route('admin.gempa.destroy', $g->id_gempa) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')" style="background:none;border:none;color:red;cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection