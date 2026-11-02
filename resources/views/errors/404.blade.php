@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5 text-center" style="max-width:560px">
    <i class="fa-solid fa-magnifying-glass fa-4x mb-3" style="color:var(--primary);opacity:.6"></i>
    <h2 class="fw-bold">404 – Halaman Tidak Ditemukan</h2>
    <p class="text-muted">Halaman yang Anda cari tidak ada atau sudah dipindahkan.</p>
    <a href="{{ route('home') }}" class="btn btn-ch px-4"><i class="fa-solid fa-house me-1"></i>Kembali ke Beranda</a>
</div>
@endsection
