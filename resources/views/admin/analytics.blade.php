@extends('layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-line me-2" style="color:var(--primary)"></i>Analytics CleanHub</h5>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><x-stat-card :value="number_format($stats['total_laporan'])" label="Total Laporan" color="#00bcd4" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="number_format($stats['laporan_selesai'])" label="Laporan Selesai" color="#28a745" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="number_format($stats['laporan_aktif'])" label="Laporan Aktif" color="#ffc107" /></div>
        <div class="col-6 col-md-3"><x-stat-card :value="number_format($stats['total_petugas'])" label="Total Petugas" color="#fd7e14" /></div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="panel p-3">
                <div class="fw-bold mb-2">Laporan Per Bulan</div>
                <canvas id="chartBulanA" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel p-3">
                <div class="fw-bold mb-2">Status Laporan</div>
                <canvas id="chartStatusA" height="180"></canvas>
            </div>
        </div>
        <div class="col-12">
            <div class="panel p-3">
                <div class="fw-bold mb-2">Area (Kecamatan) dengan Laporan Terbanyak</div>
                <canvas id="chartAreaA" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch(@json(route('admin.analytics.api')))
        .then(res => res.json())
        .then(data => {
            const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            const bulanValues = bulanLabels.map((_, i) => {
                const f = data.per_bulan.find(d => parseInt(d.bulan) - 1 === i);
                return f ? parseInt(f.total) : 0;
            });
            new Chart(document.getElementById('chartBulanA'), {
                type: 'bar',
                data: { labels: bulanLabels, datasets: [{ label: 'Laporan', data: bulanValues, backgroundColor: '#00bcd4' }] },
                options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
            });

            const statusColors = { diajukan: '#6c757d', diverifikasi: '#17a2b8', diproses: '#ffc107', ditangani: '#fd7e14', selesai: '#28a745' };
            new Chart(document.getElementById('chartStatusA'), {
                type: 'pie',
                data: {
                    labels: data.per_status.map(d => d.status),
                    datasets: [{ data: data.per_status.map(d => d.total), backgroundColor: data.per_status.map(d => statusColors[d.status] || '#ccc') }]
                },
                options: { plugins: { legend: { position: 'bottom' } } }
            });

            new Chart(document.getElementById('chartAreaA'), {
                type: 'bar',
                data: {
                    labels: data.per_area.map(d => d.kecamatan || 'Tanpa kecamatan'),
                    datasets: [{ label: 'Jumlah Laporan', data: data.per_area.map(d => d.total), backgroundColor: '#4dd0e1' }]
                },
                options: { indexAxis: 'y', plugins: { legend: { display: false } } }
            });
        });
</script>
@endpush
