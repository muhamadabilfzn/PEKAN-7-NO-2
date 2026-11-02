@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h4 class="fw-bold mb-0">Halo, {{ session('nama') }}!</h4>
        <small class="text-muted">Pantau laporan sampah Anda di sini.</small>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['total']" label="Total Laporan" color="#00bcd4" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['selesai']" label="Selesai" color="#28a745" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$stats['aktif']" label="Aktif" color="#ffc107" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="$totalSaya" label="Laporan Saya" color="#17a2b8" /></div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><i class="fa-solid fa-clipboard-list me-2" style="color:var(--primary)"></i>Laporan Terbaru Saya</span>
            <div class="d-flex gap-2">
                <a href="{{ route('laporan.create') }}" class="btn btn-sm btn-ch">
                    <i class="fa-solid fa-plus me-1"></i>Buat Laporan
                </a>
                <a href="{{ route('user.riwayat') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:50px">Semua</a>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse ($laporan as $l)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <x-category-badge :category="$l->category" />
                        <div class="fw-semibold small mt-1">{{ \Illuminate\Support\Str::limit($l->deskripsi, 60) }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $l->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="text-end">
                        <x-status-badge :status="$l->status" />
                        <div class="mt-1">
                            <a href="{{ route('laporan.show', $l->id) }}" class="small text-decoration-none">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <x-empty-state message="Belum ada laporan.">
                    <a href="{{ route('laporan.create') }}" class="small">Buat laporan pertama!</a>
                </x-empty-state>
            @endforelse
        </div>
    </div>
</div>
@endsection
