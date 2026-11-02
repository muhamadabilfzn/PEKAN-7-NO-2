@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color:var(--primary)"><i class="fa-solid fa-recycle me-2"></i>CleanHub</h2>
                <p class="text-muted">Sistem Pengaduan & Pemantauan Sampah</p>
            </div>

            <div class="card auth-card">
                <div class="auth-header text-center text-white">
                    <h5 class="mb-0 fw-bold">Daftar Akun Baru</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="nav nav-pills nav-fill mb-4">
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link active">Daftar</a></li>
                    </ul>

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                   class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama lengkap Anda">
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="username">Username</label>
                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                       class="form-control @error('username') is-invalid @enderror" placeholder="username_kamu">
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="no_hp">No. HP</label>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                       class="form-control @error('no_hp') is-invalid @enderror" placeholder="08xxxxxxxxxx">
                                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="emailReg">Email</label>
                            <input type="email" id="emailReg" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="regPass">Kata Sandi</label>
                                <input type="password" id="regPass" name="password"
                                       class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 karakter">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="konfirmasi">Konfirmasi</label>
                                <input type="password" id="konfirmasi" name="konfirmasi_password"
                                       class="form-control @error('konfirmasi_password') is-invalid @enderror" placeholder="Ulangi sandi">
                                @error('konfirmasi_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="jk">Jenis Kelamin</label>
                                <select id="jk" name="jenis_kelamin" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold" for="tgl">Tanggal Lahir</label>
                                <input type="date" id="tgl" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="2" class="form-control" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-ch w-100">
                            <i class="fa-solid fa-user-plus me-2"></i>Daftar Sekarang
                        </button>
                    </form>

                    <p class="text-center text-muted small mt-3 mb-0">
                        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--primary)">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
