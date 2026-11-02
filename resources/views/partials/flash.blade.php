@if (session('success') || session('error'))
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-0">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-0 {{ session('success') ? 'mt-2' : '' }}">
                <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif
    </div>
@endif
