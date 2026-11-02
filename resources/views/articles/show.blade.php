@extends('layouts.app')

@section('title', $artikel->judul)

@section('content')
<div class="container py-5" style="max-width:760px">
    <a href="{{ route('artikel.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i>Semua Artikel
    </a>

    <span class="kat-badge mb-3">{{ $artikel->kategori_label }}</span>
    <h1 class="fw-bold mb-2">{{ $artikel->judul }}</h1>
    <p class="text-muted small mb-4">
        <i class="fa-regular fa-user me-1"></i>{{ $artikel->penulis->nama_lengkap ?? 'CleanHub' }}
        &nbsp;·&nbsp;
        <i class="fa-regular fa-calendar me-1"></i>{{ $artikel->created_at->format('d M Y') }}
    </p>

    @if ($artikel->thumbnail_url)
        <img src="{{ $artikel->thumbnail_url }}" alt="{{ $artikel->judul }}" class="img-fluid rounded mb-3 w-100" style="max-height:380px;object-fit:cover">
    @endif

    <div class="card border-0 shadow-sm p-4">
        <div style="line-height:1.8">{!! nl2br(e($artikel->konten)) !!}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('artikel.index') }}" class="btn btn-ch px-4">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Artikel
        </a>
    </div>
</div>
@endsection
