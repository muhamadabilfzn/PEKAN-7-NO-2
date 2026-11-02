@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color:var(--primary)"><i class="fa-solid fa-recycle me-2"></i>CleanHub</h2>
                <p class="text-muted">Sistem Pengaduan & Pemantauan Sampah</p>
            </div>

            <div class="card auth-card">
                <div class="auth-header text-center text-white">
                    <h5 class="mb-0 fw-bold">Masuk ke Akun Anda</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="nav nav-pills nav-fill mb-4">
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Daftar</a></li>
                    </ul>

                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="email">Email / No. HP</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user" style="color:var(--primary)"></i></span>
                                <input type="text" id="email" name="email" value="{{ old('email') }}" required
                                       class="form-control @error('email') is-invalid @enderror" placeholder="Email atau nomor HP">
                            </div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="loginPass">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock" style="color:var(--primary)"></i></span>
                                <input type="password" id="loginPass" name="password" required
                                       class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi">
                                <button type="button" class="btn btn-outline-secondary" id="togglePass" aria-label="Tampilkan sandi">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:var(--primary)">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" class="btn btn-primary-ch w-100">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                        </button>
                    </form>

                    @if (app()->environment('local'))
                        <div class="mt-3 p-2 bg-light rounded small text-muted">
                            <strong>Demo:</strong> admin@cleanhub.id | petugas@cleanhub.id | user@cleanhub.id<br>
                            <strong>Password:</strong> cleanhub123
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.getElementById('togglePass').addEventListener('click', function () {
            const input = document.getElementById('loginPass');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.innerHTML = '<i class="fa-solid ' + (show ? 'fa-eye-slash' : 'fa-eye') + '"></i>';
        });
    </script>
@endpush
