<footer class="footer-ch py-4 mt-5 text-center">
    <div class="container">
        <p class="mb-1">
            <i class="fa-solid fa-recycle me-2" style="color:var(--primary)"></i><strong>CleanHub</strong>
        </p>
        <p class="mb-2 small">
            &copy; {{ date('Y') }} CleanHub – Workday Warriors | Sarjana Terapan Sistem Informasi Kota Cerdas, Universitas Telkom
        </p>
        <p class="mb-0 small">
            <a href="{{ route('artikel.index') }}" class="text-decoration-none" style="color:rgba(255,255,255,.6)">Artikel</a>
            &middot;
            <a href="{{ route('bantuan.index') }}" class="text-decoration-none" style="color:rgba(255,255,255,.6)">Bantuan</a>
            &middot;
            <a href="{{ route('laporan.index') }}" class="text-decoration-none" style="color:rgba(255,255,255,.6)">Pemantauan</a>
        </p>
    </div>
</footer>
