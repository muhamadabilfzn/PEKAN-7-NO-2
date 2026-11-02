@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="container py-5 text-center" style="max-width:560px">
    <i class="fa-solid fa-lock fa-4x mb-3" style="color:var(--primary);opacity:.6"></i>
    <h2 class="fw-bold">403 – Akses Ditolak</h2>
    <p class="text-muted">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>
    <a href="{{ route('home') }}" class="btn btn-ch px-4"><i class="fa-solid fa-house me-1"></i>Kembali ke Beranda</a>
</div>
@endsection
