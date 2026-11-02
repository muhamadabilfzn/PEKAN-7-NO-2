@extends('layouts.app')

@section('title', 'Sistem Pengaduan & Pemantauan Sampah')

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="badge mb-3 px-3 py-2" style="background:rgba(255,255,255,.2);border-radius:50px;font-size:.85rem">
                    <i class="fa-solid fa-leaf me-1"></i> Sistem Kota Cerdas – Universitas Telkom
                </div>
                <h1 class="mb-4">CleanHub <br><span style="color:#b2ebf2">Solusi Digital</span><br>Pengaduan Sampah</h1>
                <p class="lead mb-4 opacity-90">
                    Platform pelaporan dan pemantauan sampah berbasis cloud. Foto, deskripsikan,
                    dan kirim lokasi sampah dalam hitungan detik — petugas kami akan menanganinya.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('login') }}" class="btn btn-hero">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk Sekarang
                    </a>
                    <a href="{{ route('laporan.index') }}" class="btn btn-hero-outline">
                        <i class="fa-solid fa-map-location-dot me-2"></i>Lihat Peta Laporan
                    </a>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0">
                @php
                    $persen = $stats['total'] > 0 ? round(($stats['selesai'] / $stats['total']) * 100) : 0;
                    $heroStats = [
                        ['value' => number_format($stats['total']),   'label' => 'Total Laporan',        'color' => '#00bcd4'],
                        ['value' => number_format($stats['selesai']), 'label' => 'Laporan Selesai',      'color' => '#28a745'],
                        ['value' => number_format($stats['aktif']),   'label' => 'Laporan Aktif',        'color' => '#ffc107'],
                        ['value' => $persen . '%',                    'label' => 'Tingkat Penyelesaian', 'color' => '#17a2b8'],
                    ];
                @endphp
                <div class="row g-3">
                    @foreach ($heroStats as $s)
                        <div class="col-6">
                            <x-stat-card :value="$s['value']" :label="$s['label']" :color="$s['color']" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section id="tentang" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge mb-2" style="background:rgba(0,188,212,.1);color:var(--primary)">TENTANG CLEANHUB</span>
                <h2 class="fw-bold mb-3">Apa itu Laporan Sampah?</h2>
                <p class="text-muted mb-4">
                    Laporan Sampah adalah pengaduan digital yang dikirim masyarakat ketika menemukan
                    titik sampah liar, tumpukan sampah yang tidak terangkut, atau pencemaran lingkungan
                    di sekitar mereka. Setiap laporan otomatis tercatat dengan foto, deskripsi,
                    kategori sampah, dan lokasi GPS — lalu masuk ke sistem pemantauan admin
                    untuk diverifikasi dan ditugaskan kepada petugas kebersihan terdekat.
                </p>
                @php
                    $fitur = [
                        ['Real-time Tracking',     'Pantau status laporan dari awal sampai selesai'],
                        ['Lokasi GPS Akurat',      'Titik sampah terpetakan otomatis di peta'],
                        ['Notifikasi Otomatis',    'Update status dikirim langsung ke akun Anda'],
                        ['Petugas Terverifikasi',  'Ditangani langsung oleh petugas kebersihan resmi'],
                    ];
                @endphp
                <div class="row g-3">
                    @foreach ($fitur as [$judul, $desk])
                        <div class="col-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-check fa-lg mt-1" style="color:var(--primary)"></i>
                                <div>
                                    <div class="fw-bold small">{{ $judul }}</div>
                                    <div class="text-muted small">{{ $desk }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="monitor-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-map-location-dot me-2" style="color:var(--primary)"></i>Dashboard Pemantauan Publik</h5>
                    <p class="text-muted small mb-3">
                        Semua laporan yang masuk bisa dipantau secara terbuka oleh siapa saja —
                        lihat statusnya, lokasinya di peta, dan kategorinya.
                    </p>
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        @foreach (\App\Models\WasteReport::STATUSES as $s)
                            <x-status-badge :status="$s" class="status-pill" />
                        @endforeach
                    </div>
                    <a href="{{ route('laporan.index') }}" class="btn btn-ch w-100 fw-bold py-2">
                        <i class="fa-solid fa-eye me-2"></i>Buka Dashboard Pemantauan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA KERJA --}}
<section id="cara-kerja" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Cara Kerja CleanHub</h2>
        <p class="text-center text-muted mb-5">3 langkah mudah untuk melaporkan sampah</p>
        @php
            $langkah = [
                ['num' => '1', 'icon' => 'fa-camera',         'title' => 'Laporkan',              'desc' => 'Foto sampah, isi deskripsi, dan lokasi GPS otomatis terdeteksi. Laporan terkirim dalam hitungan detik.'],
                ['num' => '2', 'icon' => 'fa-magnifying-glass','title' => 'Verifikasi & Assign',   'desc' => 'Admin memverifikasi laporan dan menugaskan petugas kebersihan terdekat untuk menangani.'],
                ['num' => '3', 'icon' => 'fa-check-circle',   'title' => 'Selesai & Notifikasi',  'desc' => 'Petugas menyelesaikan tugas. Kamu mendapat notifikasi bahwa laporan sudah ditangani.'],
            ];
        @endphp
        <div class="row g-4 justify-content-center">
            @foreach ($langkah as $l)
                <div class="col-md-4">
                    <div class="text-center p-4 bg-white rounded-4 h-100" style="box-shadow:0 4px 16px rgba(0,0,0,.04)">
                        <div class="step-num mx-auto mb-3">{{ $l['num'] }}</div>
                        <div class="feature-icon mx-auto"><i class="fa-solid {{ $l['icon'] }}"></i></div>
                        <h5 class="fw-bold">{{ $l['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $l['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- DAMPAK LINGKUNGAN --}}
<section id="dampak" class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Dampak Lingkungan</h2>
        <p class="text-center text-muted mb-5">Progres penanganan sampah dari laporan masyarakat</p>

        @php $persenAktif = $stats['total'] > 0 ? round(($stats['aktif'] / $stats['total']) * 100) : 0; @endphp
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="impact-card mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold small">Tingkat Penyelesaian Laporan</span>
                        <span class="fw-bold" style="color:var(--primary)">{{ $persen }}%</span>
                    </div>
                    <div class="progress" style="height:10px;border-radius:50px">
                        <div class="progress-bar" style="width:{{ $persen }}%;background:var(--primary)"></div>
                    </div>
                </div>
                <div class="impact-card mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-semibold small">Laporan Sedang Ditangani</span>
                        <span class="fw-bold" style="color:#ffc107">{{ $persenAktif }}%</span>
                    </div>
                    <div class="progress" style="height:10px;border-radius:50px">
                        <div class="progress-bar" style="width:{{ $persenAktif }}%;background:#ffc107"></div>
                    </div>
                </div>
                <div class="impact-card">
                    <p class="small text-muted mb-0">
                        <i class="fa-solid fa-circle-info me-1" style="color:var(--primary)"></i>
                        Setiap laporan yang selesai ditangani berkontribusi mengurangi pencemaran
                        lingkungan dan menjaga kebersihan area sekitar Anda.
                    </p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="impact-card"><canvas id="chartDampak" height="180"></canvas></div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA / ARTIKEL --}}
<section id="berita" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Berita & Edukasi Lingkungan</h2>
        <p class="text-center text-muted mb-5">Tips dan informasi terbaru seputar kebersihan</p>

        <div class="row g-4">
            @forelse ($artikel as $a)
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('artikel.show', $a->slug) }}" class="text-decoration-none text-dark">
                        <div class="artikel-card">
                            <div class="artikel-thumb"><i class="fa-solid {{ $a->kategori_ikon }}"></i></div>
                            <div class="p-3">
                                <span class="artikel-cat">{{ $a->kategori_label }}</span>
                                <h6 class="fw-bold mt-1 mb-2">{{ $a->judul }}</h6>
                                <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($a->konten), 80) }}</p>
                                <small class="text-muted"><i class="fa-solid fa-calendar me-1"></i>{{ $a->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state icon="fa-newspaper" message="Belum ada artikel yang dipublikasikan." />
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Siap Melaporkan Sampah?</h2>
        <p class="lead mb-4 opacity-90">Bergabung bersama warga lain yang sudah menggunakan CleanHub</p>
        <a href="{{ route('register') }}" class="btn btn-hero">
            <i class="fa-solid fa-user-plus me-2"></i>Daftar Gratis Sekarang
        </a>
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartDampak'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Sedang Ditangani'],
                datasets: [{
                    data: [@json($stats['selesai']), @json($stats['aktif'])],
                    backgroundColor: ['#28a745', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, cutout: '65%', plugins: { legend: { position: 'bottom' } } }
        });
    </script>
@endpush
