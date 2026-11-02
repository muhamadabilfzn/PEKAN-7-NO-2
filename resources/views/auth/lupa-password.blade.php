@extends('layouts.app')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="container py-5" style="max-width:520px">
    <div class="card auth-card">
        <div class="auth-header text-center text-white">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-key me-2"></i>Lupa Kata Sandi</h5>
        </div>
        <div class="card-body p-4 text-center">
            <p class="text-muted">
                Pengaturan ulang kata sandi dilakukan oleh administrator. Silakan hubungi kami
                melalui halaman Bantuan dengan menyertakan email atau nomor HP akun Anda.
            </p>
            <a href="{{ route('bantuan.index') }}" class="btn btn-primary-ch px-4">
                <i class="fa-solid fa-headset me-2"></i>Hubungi Bantuan
            </a>
            <div class="mt-3">
                <a href="{{ route('login') }}" class="small text-decoration-none" style="color:var(--primary)">
                    <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
