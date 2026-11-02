@extends('layouts.app')

@section('title', 'Artikel & Edukasi')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-1">Artikel & Edukasi</h2>
    <p class="text-muted mb-4">Tips dan informasi seputar pengelolaan sampah</p>

    <div class="row g-4">
        @forelse ($artikel as $a)
            <div class="col-md-6 col-lg-4">
                <div class="card artikel-card border-0 h-100">
                    @if ($a->thumbnail_url)
                        <img src="{{ $a->thumbnail_url }}" alt="{{ $a->judul }}" class="card-img-top" style="height:170px;object-fit:cover">
                    @endif
                    <div class="card-body p-4">
                        <span class="kat-badge mb-3">{{ $a->kategori_label }}</span>
                        <h5 class="fw-bold">{{ $a->judul }}</h5>
                        <p class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($a->konten), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">{{ $a->created_at->format('d M Y') }}</small>
                            <a href="{{ route('artikel.show', $a->slug) }}" class="btn btn-sm btn-ch px-3">Baca</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <x-empty-state icon="fa-newspaper" message="Belum ada artikel yang dipublikasikan." />
            </div>
        @endforelse
    </div>
</div>
@endsection
