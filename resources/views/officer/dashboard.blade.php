@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
@include('partials.leaflet')

<div class="container-fluid py-4 px-3 px-md-4">

    <div class="mb-3">
        <h5 class="fw-bold mb-0">{{ $officer->user->nama_lengkap }}</h5>
        <small class="text-muted"><i class="fa-solid fa-map-pin me-1"></i>{{ $officer->area_kerja ?? 'Area belum diset' }}</small>
    </div>

    {{-- Statistik + saldo --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['pending']" label="Tugas Masuk" color="#ffc107" icon="fa-clock" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['aktif']" label="Sedang Ditangani" color="#17a2b8" icon="fa-spinner" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['selesai']" label="Tugas Selesai" color="#28a745" icon="fa-check-double" /></div>
        <div class="col-6 col-md-3">
            <div class="wallet-card">
                <div class="small opacity-75 mb-1"><i class="fa-solid fa-wallet me-1"></i>Dompet Saldo</div>
                <div class="amount">Rp {{ number_format($stats['saldo'], 0, ',', '.') }}</div>
                <div style="font-size:.75rem;opacity:.7">dari tugas selesai (Rp 15.000/tugas)</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Tugas aktif --}}
        <div class="col-lg-7">
            <div class="panel">
                <div class="panel-title">
                    <span><i class="fa-solid fa-list-check me-2" style="color:var(--primary)"></i>Tugas Aktif</span>
                    <a href="{{ route('officer.tugasku') }}" class="btn btn-sm btn-ch px-3">Semua Tugas</a>
                </div>

                @forelse ($tugasAktif as $t)
                    <div class="tugas-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="kat-pill" style="background: {{ $t->report->category->warna }}22; color: {{ $t->report->category->warna }}">
                                    <i class="fa-solid {{ $t->report->category->icon }}"></i> {{ $t->report->category->nama }}
                                </span>
                                <x-status-badge :status="$t->status" class="ms-2" />
                            </div>
                            <small class="text-muted">Laporan #{{ $t->report_id }} · Rp 15.000</small>
                        </div>
                        <p class="mb-2 small">{{ \Illuminate\Support\Str::limit($t->report->deskripsi, 100) }}</p>
                        @if ($t->catatan)
                            <p class="mb-2 small text-muted"><i class="fa-regular fa-note-sticky me-1"></i>{{ $t->catatan }}</p>
                        @endif
                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <small class="text-muted">
                                <i class="fa-solid fa-location-dot me-1" style="color:var(--primary)"></i>
                                {{ $t->report->alamat_detail ?? 'Lokasi belum tersedia' }}
                            </small>

                            @if ($t->status === 'pending')
                                <form action="{{ route('officer.ambil', $t->id) }}" method="POST" onsubmit="return confirm('Ambil tugas ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-ch px-3"><i class="fa-solid fa-hand me-1"></i>Ambil</button>
                                </form>
                            @elseif ($t->status === 'diterima')
                                <form action="{{ route('officer.selesai', $t->id) }}" method="POST" onsubmit="return confirm('Tandai tugas selesai?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success px-3"><i class="fa-solid fa-check me-1"></i>Selesai</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <x-empty-state icon="fa-check-double" message="Tidak ada tugas aktif saat ini." />
                @endforelse
            </div>
        </div>

        {{-- Peta + riwayat --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header fw-bold bg-white">
                    <i class="fa-solid fa-map me-2" style="color:var(--primary)"></i>Peta Lokasi Tugas
                </div>
                <div class="card-body p-2"><div id="tugasMap"></div></div>
            </div>

            <div class="panel">
                <div class="panel-title">
                    <span><i class="fa-solid fa-history me-2 text-success"></i>Riwayat Selesai</span>
                </div>
                @forelse ($tugasSelesai as $s)
                    <div class="tugas-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="small fw-semibold">{{ $s->report->category->nama }}</span>
                                <x-status-badge status="selesai" class="ms-2" />
                            </div>
                            <small class="text-success fw-bold">+Rp 15.000</small>
                        </div>
                        <p class="mb-0 small text-muted mt-1">{{ \Illuminate\Support\Str::limit($s->report->deskripsi, 60) }}</p>
                        <small class="text-muted">{{ $s->selesai_at ? $s->selesai_at->format('d M Y H:i') : '-' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted py-3 small">Belum ada tugas selesai</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const map = L.map('tugasMap').setView([-6.9175, 107.6771], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

    const tugasAktif = @json($mapData);

    tugasAktif.forEach(t => {
        if (!t.lat || !t.lng) return;
        const color = t.status === 'diterima' ? '#17a2b8' : '#ffc107';
        const icon = L.divIcon({
            html: `<div style="background:${color};width:16px;height:16px;border-radius:50%;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.3)"></div>`,
            iconSize: [16, 16], iconAnchor: [8, 8]
        });
        L.marker([t.lat, t.lng], { icon }).addTo(map).bindPopup(`<strong>${t.kat}</strong><br>${t.desc.substring(0, 60)}...`);
    });
</script>
@endpush
