@extends('layouts.app')

@section('title', 'Peta Kerapatan Gempa - Sesar Opak')

@section('content')

    {{-- Leaflet CSS --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <h2 style="text-align:center; margin:16px; font-family:sans-serif;">
        Peta Kerapatan Gempa - Sesar Opak
    </h2>

    <div
        id="peta-gempa"
        style="height:600px; width:100%;"
    ></div>

    <p
        id="status"
        style="text-align:center; font-family:sans-serif; color:#666;"
    >
        Memuat data...
    </p>

@endsection


@push('scripts')

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Leaflet Heat --}}
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const statusEl = document.getElementById('status');
            const mapElement = document.getElementById('peta-gempa');

            // =====================================================
            // 1. CEK LEAFLET
            // =====================================================

            if (typeof L === 'undefined') {
                statusEl.textContent = 'ERROR: Leaflet tidak berhasil dimuat.';
                console.error('Leaflet tidak ditemukan.');
                return;
            }

            // =====================================================
            // 2. CEK LEAFLET HEAT
            // =====================================================

            if (typeof L.heatLayer !== 'function') {
                statusEl.textContent = 'ERROR: Plugin Leaflet Heat tidak berhasil dimuat.';
                console.error('L.heatLayer tidak ditemukan.');
                return;
            }

            // =====================================================
            // 3. BUAT MAP
            // =====================================================

            const mapInstance = L.map(mapElement, {
                center: [-7.88, 110.40],
                zoom: 11
            });

            // =====================================================
            // 4. TILE MAP
            // =====================================================

            const tileLayer = L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }
            );

            tileLayer.addTo(mapInstance);

            // Kalau tile gagal dimuat
            tileLayer.on('tileerror', function (error) {
                console.error('Tile OpenStreetMap gagal dimuat:', error);
            });

            // =====================================================
            // 5. PAKSA LEAFLET MENGHITUNG ULANG UKURAN CONTAINER
            // =====================================================

            setTimeout(function () {
                mapInstance.invalidateSize();
            }, 300);


            // =====================================================
            // 6. AMBIL DATA GEMPA DARI API
            // =====================================================

            fetch('/api/gempa')
                .then(function (response) {

                    if (!response.ok) {
                        throw new Error(
                            'HTTP ' + response.status + ' - API gempa gagal diakses.'
                        );
                    }

                    return response.json();
                })

                .then(function (data) {

                    console.log('=== DATA GEMPA ===');
                    console.log(data);

                    // =================================================
                    // 7. FILTER DATA KOORDINAT
                    // =================================================

                    const validData = data.filter(function (g) {

                        const latitude = parseFloat(g.latitude);
                        const longitude = parseFloat(g.longitude);

                        return (
                            !isNaN(latitude) &&
                            !isNaN(longitude) &&
                            latitude >= -90 &&
                            latitude <= 90 &&
                            longitude >= -180 &&
                            longitude <= 180
                        );
                    });

                    console.log('=== DATA VALID ===');
                    console.log(validData);

                    // =================================================
                    // 8. BUAT TITIK HEATMAP
                    // =================================================

                    const heatPoints = validData.map(function (g) {

                        const latitude = parseFloat(g.latitude);
                        const longitude = parseFloat(g.longitude);

                        return [
                            latitude,
                            longitude,
                            1
                        ];
                    });

                    console.log('=== HEAT POINTS ===');
                    console.log(heatPoints);


                    // =================================================
                    // 9. CEK APAKAH DATA HEATMAP ADA
                    // =================================================

                    if (heatPoints.length === 0) {

                        statusEl.textContent =
                            'Tidak ada koordinat gempa yang valid.';

                        console.error(
                            'Heatmap tidak dibuat karena heatPoints kosong.'
                        );

                        return;
                    }


                    // =================================================
                    // 10. BUAT HEATMAP
                    // =================================================

                    const heatLayer = L.heatLayer(
                        heatPoints,
                        {
                            radius: 35,
                            blur: 25,
                            maxZoom: 17,

                            minOpacity: 0.35,

                            gradient: {
                                0.20: 'blue',
                                0.40: 'lime',
                                0.60: 'yellow',
                                0.80: 'orange',
                                1.00: 'red'
                            }
                        }
                    );

                    heatLayer.addTo(mapInstance);


                    // =================================================
                    // 11. STATUS
                    // =================================================

                    statusEl.textContent =
                        'Menampilkan ' +
                        validData.length +
                        ' data gempa.';


                    // =================================================
                    // 12. SESUAIKAN MAP DENGAN DATA GEMPA
                    // =================================================

                    const bounds = L.latLngBounds(
                        heatPoints.map(function (point) {
                            return [
                                point[0],
                                point[1]
                            ];
                        })
                    );

                    if (bounds.isValid()) {

                        mapInstance.fitBounds(bounds, {
                            padding: [30, 30],
                            maxZoom: 12
                        });

                    }


                    // =================================================
                    // 13. INVALIDATE SIZE SEKALI LAGI
                    // =================================================

                    setTimeout(function () {
                        mapInstance.invalidateSize();
                    }, 500);

                })

                .catch(function (err) {

                    console.error(
                        'ERROR API GEMPA:',
                        err
                    );

                    statusEl.textContent =
                        'Gagal memuat data gempa: ' +
                        err.message;
                });

        });
    </script>

@endpush