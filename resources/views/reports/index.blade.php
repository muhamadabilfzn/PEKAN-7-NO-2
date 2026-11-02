@extends('layouts.app')

@section('title', 'Dashboard Pemantauan')

@section('content')
@include('partials.leaflet')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">
            <i class="fa-solid fa-map-location-dot me-2" style="color:var(--primary)"></i>Dashboard Pemantauan Sampah
        </h4>
        @if (session('role') === 'masyarakat')
            <a href="{{ route('laporan.create') }}" class="btn btn-ch px-4">
                <i class="fa-solid fa-plus me-2"></i>Buat Laporan
            </a>
        @endif
    </div>

    {{-- Ringkasan angka --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['total']" label="Total Laporan" color="#00bcd4" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['selesai']" label="Selesai" color="#28a745" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['aktif']" label="Aktif" color="#ffc107" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$reports->total()" label="Hasil Pencarian" color="#17a2b8" /></div>
    </div>

    @include('partials.report-filter', ['action' => route('laporan.index')])

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#listView" type="button">
                <i class="fa-solid fa-list me-1"></i>List View
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#mapView" type="button" id="btnMapTab">
                <i class="fa-solid fa-map me-1"></i>Map View
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="listView">
            <div class="row g-3">
                @forelse ($reports as $r)
                    <div class="col-md-6 col-lg-4">
                        <x-report-card :report="$r" />
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state message="Tidak ada laporan ditemukan." />
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $reports->links() }}
            </div>
        </div>

        <div class="tab-pane fade" id="mapView">
            <div id="peta"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let petaMap = null;

    function initMap() {
        if (petaMap) { petaMap.invalidateSize(); return; }

        petaMap = L.map('peta').setView([-6.9175, 107.6771], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(petaMap);

        fetch(@json(route('laporan.markers')))
            .then(res => res.json())
            .then(json => {
                (json.data || []).forEach(r => {
                    if (!r.latitude || !r.longitude) return;
                    const icon = L.divIcon({
                        html: `<div style="background:${r.warna};width:16px;height:16px;border-radius:50%;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.3)"></div>`,
                        iconSize: [16, 16], iconAnchor: [8, 8]
                    });
                    L.marker([r.latitude, r.longitude], { icon }).addTo(petaMap)
                     .bindPopup(`<strong>${r.kategori}</strong><br>${r.deskripsi.substring(0, 60)}...<br><span class="badge badge-${r.status}">${r.status}</span>`);
                });
            });
    }

    document.getElementById('btnMapTab').addEventListener('click', () => setTimeout(initMap, 200));
</script>
@endpush
