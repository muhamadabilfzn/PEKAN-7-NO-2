@extends('layouts.app')

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
@if ($report->latitude && $report->longitude)
    @include('partials.leaflet')
@endif

<div class="container-fluid py-4 px-3 px-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali
            </a>
            <span class="fw-bold">Detail Laporan #{{ $report->id }}</span>
        </div>
        <x-status-badge :status="$report->status" class="px-3 py-2" />
    </div>

    <div class="row g-3">
        {{-- Informasi laporan --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="color:var(--primary)"><i class="fa-solid fa-file-lines me-2"></i>Informasi Laporan</h6>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="small text-muted">Pelapor</div>
                            <div class="fw-semibold">{{ $report->user->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $report->user->email }} | {{ $report->user->no_hp }}</div>
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
                            <div class="small text-muted">Iuran Penanganan</div>
                            <div class="fw-bold text-success">Rp {{ number_format($report->iuran, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted mb-1">Deskripsi Masalah</div>
                        <div class="p-3 rounded" style="background:#f8f9fa">{{ $report->deskripsi }}</div>
                    </div>

                    @if ($report->alamat_detail)
                        <div class="mb-3">
                            <div class="small text-muted mb-1"><i class="fa-solid fa-location-dot me-1" style="color:var(--primary)"></i>Lokasi</div>
                            <div>{{ $report->alamat_detail }}</div>
                            @if ($report->latitude && $report->longitude)
                                <div id="detailMap" class="mt-2"></div>
                            @endif
                        </div>
                    @endif

                    @if ($report->images->isNotEmpty())
                        <div>
                            <div class="small text-muted mb-2">Foto Bukti ({{ $report->images->count() }})</div>
                            <div class="row g-2">
                                @foreach ($report->images as $img)
                                    <div class="col-4">
                                        <a href="{{ asset($img->file_path) }}" target="_blank">
                                            <img src="{{ asset($img->file_path) }}" alt="Foto laporan" class="img-fluid rounded"
                                                 style="height:100px;width:100%;object-fit:cover">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="color:var(--primary)"><i class="fa-solid fa-timeline me-2"></i>Tracking Status</h6>
                    @include('partials.report-tracker', ['status' => $report->status])
                </div>
            </div>
        </div>

        {{-- Panel aksi --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header fw-bold bg-white">
                    <i class="fa-solid fa-pen-to-square me-2" style="color:var(--primary)"></i>Update Status
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.status', $report->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select mb-3" aria-label="Status">
                            @foreach (\App\Models\WasteReport::STATUSES as $s)
                                <option value="{{ $s }}" @selected($report->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-ch w-100"><i class="fa-solid fa-rotate me-1"></i>Update Status</button>
                    </form>
                </div>
            </div>

            @if (in_array($report->status, ['diverifikasi', 'diproses']))
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header fw-bold bg-white">
                        <i class="fa-solid fa-hard-hat me-2" style="color:#fd7e14"></i>Assign Petugas
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.laporan.assign', $report->id) }}" method="POST">
                            @csrf
                            <select name="officer_id" class="form-select mb-2" required aria-label="Petugas">
                                <option value="">-- Pilih Petugas --</option>
                                @foreach ($petugas as $p)
                                    <option value="{{ $p->id }}">{{ $p->user->nama_lengkap }} ({{ $p->area_kerja ?? 'Area belum diset' }})</option>
                                @endforeach
                            </select>
                            <textarea name="catatan" class="form-control mb-2" rows="2" placeholder="Catatan untuk petugas..."></textarea>
                            <button type="submit" class="btn w-100 text-white" style="background:#fd7e14;border-radius:50px">
                                <i class="fa-solid fa-user-check me-1"></i>Assign Petugas
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if ($report->status === 'diajukan')
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body text-center">
                        <p class="small text-muted mb-3">Laporan ini belum diverifikasi. Periksa informasi lalu klik tombol berikut.</p>
                        <form action="{{ route('admin.laporan.verify', $report->id) }}" method="POST"
                              onsubmit="return confirm('Verifikasi laporan #{{ $report->id }}?')">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" style="border-radius:50px">
                                <i class="fa-solid fa-shield-halved me-1"></i>Verifikasi Laporan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm border-danger">
                <div class="card-body text-center">
                    <form action="{{ route('admin.laporan.destroy', $report->id) }}" method="POST"
                          onsubmit="return confirm('Hapus laporan ini permanen? Tidak bisa dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fa-solid fa-trash me-1"></i>Hapus Laporan
                        </button>
                    </form>
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
        L.marker([@json($report->latitude), @json($report->longitude)]).addTo(dMap).bindPopup('Lokasi laporan sampah').openPopup();
    </script>
    @endpush
@endif
