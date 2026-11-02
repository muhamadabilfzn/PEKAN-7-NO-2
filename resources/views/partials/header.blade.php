@php
    $role    = session('role');
    $isLogin = session('is_login');

    // [nama route, label, ikon, pola route aktif]
    $menus = match ($role) {
        'admin' => [
            ['admin.dashboard',       'Dashboard', 'fa-gauge',          'admin.dashboard'],
            ['admin.users.index',     'User',      'fa-users',          'admin.users.*'],
            ['admin.laporan.index',   'Laporan',   'fa-clipboard-list', 'admin.laporan.*'],
            ['admin.petugas.index',   'Petugas',   'fa-hard-hat',       'admin.petugas.*'],
            ['admin.artikel.index',   'Artikel',   'fa-newspaper',      'admin.artikel.*'],
            ['admin.analytics.index', 'Analytics', 'fa-chart-line',     'admin.analytics.*'],
        ],
        'petugas' => [
            ['officer.dashboard', 'Dashboard',   'fa-gauge',      'officer.dashboard'],
            ['officer.tugasku',   'Semua Tugas', 'fa-list-check', 'officer.tugasku'],
            ['laporan.index',     'Pemantauan',  'fa-map',        'laporan.index'],
            ['artikel.index',     'Artikel',     'fa-newspaper',  'artikel.*'],
        ],
        'masyarakat' => [
            ['user.dashboard',  'Dashboard',    'fa-gauge',             'user.dashboard'],
            ['laporan.create',  'Buat Laporan', 'fa-plus',              'laporan.create'],
            ['user.riwayat',    'Riwayat',      'fa-clock-rotate-left', 'user.riwayat'],
            ['laporan.index',   'Pemantauan',   'fa-map',               'laporan.index'],
            ['artikel.index',   'Artikel',      'fa-newspaper',         'artikel.*'],
            ['user.profil',     'Profil',       'fa-user',              'user.profil'],
        ],
        default => [
            ['home',           'Beranda',    'fa-house',           'home'],
            ['laporan.index',  'Pemantauan', 'fa-map',             'laporan.*'],
            ['artikel.index',  'Artikel',    'fa-newspaper',       'artikel.*'],
            ['bantuan.index',  'Bantuan',    'fa-circle-question', 'bantuan.*'],
        ],
    };
@endphp

<nav class="navbar navbar-expand-xl navbar-dark navbar-ch sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            <i class="fa-solid fa-recycle me-2"></i>Clean<span>Hub</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            {{-- Menu utama (berbeda tiap role) --}}
            <ul class="navbar-nav me-auto gap-xl-1 mt-2 mt-xl-0">
                @foreach ($menus as [$routeName, $label, $icon, $pattern])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}" href="{{ route($routeName) }}">
                            <i class="fa-solid {{ $icon }} me-1"></i>{{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Sisi kanan: notifikasi + akun --}}
            <div class="d-flex align-items-center gap-2 mt-2 mt-xl-0">
                @if ($isLogin)
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light position-relative" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifikasi">
                            <i class="fa-solid fa-bell"></i>
                            @if ($notifCount > 0)
                                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">{{ $notifCount }}</span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow notif-menu p-0">
                            <div class="px-3 py-2 fw-bold border-bottom d-flex justify-content-between align-items-center">
                                <span style="color:var(--primary)">Notifikasi</span>
                                @if ($notifCount > 0)
                                    <form action="{{ route('notif.readAll') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-link btn-sm p-0 text-muted text-decoration-none">Baca semua</button>
                                    </form>
                                @endif
                            </div>
                            @forelse ($notifList as $n)
                                <a href="{{ route('notif.read', $n->id) }}" class="dropdown-item py-2 border-bottom text-wrap">
                                    <div class="fw-semibold small">{{ $n->judul }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $n->pesan }}</div>
                                </a>
                            @empty
                                <div class="text-center text-muted py-3 small">Tidak ada notifikasi</div>
                            @endforelse
                        </div>
                    </div>

                    <span class="text-white small d-none d-xl-inline">
                        <i class="fa-solid fa-circle-user me-1"></i>{{ session('nama') }}
                        <span class="badge bg-light text-dark ms-1">{{ ucfirst($role) }}</span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light fw-semibold">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-user-plus me-1"></i>Daftar
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-sm btn-light fw-bold">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>Login
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
