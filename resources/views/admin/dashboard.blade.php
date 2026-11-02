@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0">Dashboard Administrator</h5>
            <small class="text-muted">Ringkasan seluruh aktivitas CleanHub</small>
        </div>
        <span class="text-muted small">{{ now()->format('d M Y') }}</span>
    </div>

    @php
        $cards = [
            ['icon' => 'fa-users',          'value' => $stats['total_user'],      'label' => 'Total User',      'color' => '#00bcd4'],
            ['icon' => 'fa-clipboard-list', 'value' => $stats['total_laporan'],   'label' => 'Total Laporan',   'color' => '#6f42c1'],
            ['icon' => 'fa-check-circle',   'value' => $stats['laporan_selesai'], 'label' => 'Laporan Selesai', 'color' => '#28a745'],
            ['icon' => 'fa-spinner',        'value' => $stats['laporan_aktif'],   'label' => 'Laporan Aktif',   'color' => '#ffc107'],
            ['icon' => 'fa-hard-hat',       'value' => $stats['total_petugas'],   'label' => 'Total Petugas',   'color' => '#fd7e14'],
            ['icon' => 'fa-newspaper',      'value' => $stats['total_artikel'],   'label' => 'Total Artikel',   'color' => '#17a2b8'],
        ];
    @endphp
    <div class="row g-3 mb-4">
        @foreach ($cards as $c)
            <div class="col-6 col-md-4 col-xl-2">
                <x-stat-card :value="number_format($c['value'])" :label="$c['label']" :color="$c['color']" :icon="$c['icon']" />
            </div>
        @endforeach
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="panel p-3">
                <div class="fw-bold mb-2"><i class="fa-solid fa-chart-line me-2" style="color:var(--primary)"></i>Laporan Per Bulan ({{ date('Y') }})</div>
                <canvas id="chartBulan" height="100"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel p-3">
                <div class="fw-bold mb-2"><i class="fa-solid fa-chart-pie me-2" style="color:var(--primary)"></i>Status Laporan</div>
                <canvas id="chartStatus" height="180"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="panel">
                <div class="panel-title">
                    <span><i class="fa-solid fa-clipboard-list me-2" style="color:var(--primary)"></i>Laporan Terbaru</span>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-ch px-3">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>#</th><th>Pelapor</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
                        <tbody>
                            @forelse ($laporanBaru as $l)
                                <tr>
                                    <td class="text-muted small">#{{ $l->id }}</td>
                                    <td>{{ $l->user->nama_lengkap }}</td>
                                    <td><span class="badge bg-secondary">{{ $l->category->nama }}</span></td>
                                    <td><x-status-badge :status="$l->status" /></td>
                                    <td class="small text-muted">{{ $l->created_at->format('d/m/Y') }}</td>
                                    <td><a href="{{ route('admin.laporan.show', $l->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada laporan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="panel">
                <div class="panel-title">
                    <span><i class="fa-solid fa-users me-2" style="color:var(--primary)"></i>User Terbaru</span>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-ch px-3">Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>Nama</th><th>Role</th><th>Daftar</th></tr></thead>
                        <tbody>
                            @foreach ($userBaru as $u)
                                <tr>
                                    <td>
                                        <div class="fw-semibold small">{{ $u->nama_lengkap }}</div>
                                        <div class="text-muted" style="font-size:.75rem">{{ $u->email }}</div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $u->role->display_name }}</span></td>
                                    <td class="small text-muted">{{ $u->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    const bulanData   = @json($chartBulan);
    const bulanValues = bulanLabels.map((_, i) => {
        const found = bulanData.find(d => parseInt(d.bulan) - 1 === i);
        return found ? parseInt(found.total) : 0;
    });

    new Chart(document.getElementById('chartBulan'), {
        type: 'line',
        data: { labels: bulanLabels, datasets: [{
            label: 'Laporan', data: bulanValues, borderColor: '#00bcd4', backgroundColor: 'rgba(0,188,212,.1)',
            tension: .4, fill: true, pointRadius: 5, pointBackgroundColor: '#00bcd4'
        }]},
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
    });

    const statusData   = @json($chartStatus);
    const statusColors = { diajukan: '#6c757d', diverifikasi: '#17a2b8', diproses: '#ffc107', ditangani: '#fd7e14', selesai: '#28a745' };

    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.status),
            datasets: [{ data: statusData.map(d => d.total), backgroundColor: statusData.map(d => statusColors[d.status] || '#ccc'), borderWidth: 2 }]
        },
        options: { responsive: true, cutout: '65%', plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
    });
</script>
@endpush
