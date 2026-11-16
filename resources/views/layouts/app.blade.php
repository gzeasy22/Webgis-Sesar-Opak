<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sesar Opak - WebGIS')</title>
   {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
@vite(['resources/js/app.js'])
<body>
    <nav style="background:#1e293b; padding:12px 20px; font-family: sans-serif; display:flex; align-items:center; gap:15px;">
        <img src="{{ asset('images/logo-bmkg.png') }}" alt="Logo BMKG" style="height:40px;">
        <img src="{{ asset('images/logo-upn.png') }}" alt="Logo UPN" style="height:40px;">
        <span style="color:white; font-weight:bold; margin-right:auto;">Sesar Opak - WebGIS</span>
        <a href="{{ url('/peta') }}" style="color:white; text-decoration:none;">Peta</a>
        <a href="{{ route('admin.gempa.index') }}" style="color:white; text-decoration:none;">Admin Gempa</a>
        <a href="{{ url('/tentang') }}" style="color:white; text-decoration:none;">Tentang</a>
    </nav>

    <div>
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>