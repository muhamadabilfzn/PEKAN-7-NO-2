@extends('layouts.app')

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
@if ($report->latitude && $report->longitude)
    @include('partials.leaflet')
@endif

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Pemantauan
            </a>

            <div class="card border-0 shadow-sm">
                <div class="card-header card-header-ch">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Laporan #{{ $report->id }}</h5>
                        <x-status-badge :status="$report->status" class="px-3 py-2" />
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3" style="color:var(--primary)">Tracking Status</h6>
                        @include('partials.report-tracker', ['status' => $report->status])
                    </div>

                    <hr>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="small text-muted">Pelapor</div>
                            <div class="fw-semibold">{{ $report->user->nama_lengkap }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Kategori</div>
                            <x-category-badge :category="$report->category" />
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Tanggal Lapor</div>
                            <div class="fw-semibold">{{ $report->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Iuran</div>
                            <div class="fw-bold text-success">Rp {{ number_format($report->iuran, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted mb-1">Deskripsi</div>
                        <div class="p-3 rounded" style="background:#f8f9fa">{{ $report->deskripsi }}</div>
                    </div>

                    @if ($report->alamat_detail)
                        <div class="mb-3">
                            <div class="small text-muted mb-1">
                                <i class="fa-solid fa-location-dot me-1" style="color:var(--primary)"></i>Lokasi
                            </div>
                            <div>{{ $report->alamat_detail }}</div>
                            @if ($report->latitude && $report->longitude)
                                <div id="detailMap" class="mt-2"></div>
                            @endif
                        </div>
                    @endif

                    @if ($report->images->isNotEmpty())
                        <div>
                            <div class="small text-muted mb-2">Foto Bukti</div>
                            <div class="row g-2">
                                @foreach ($report->images as $img)
                                    <div class="col-4">
                                        <a href="{{ asset($img->file_path) }}" target="_blank">
                                            <img src="{{ asset($img->file_path) }}" alt="Foto laporan" class="img-fluid rounded"
                                                 style="height:120px;width:100%;object-fit:cover">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if ($report->latitude && $report->longitude)
    @push('scripts')
    <script>
        const dMap = L.map('detailMap').setView([@json($report->latitude), @json($report->longitude)], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(dMap);
        L.marker([@json($report->latitude), @json($report->longitude)]).addTo(dMap).bindPopup('Lokasi laporan').openPopup();
    </script>
    @endpush
@endif
