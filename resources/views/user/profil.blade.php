@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4" style="max-width:640px">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-user-pen me-2" style="color:var(--primary)"></i>Edit Profil</h5>

            <form action="{{ route('user.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $profil->nama_lengkap) }}"
                           class="form-control @error('nama_lengkap') is-invalid @enderror">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email <span class="text-muted fw-normal">(tidak bisa diubah)</span></label>
                    <input type="email" class="form-control" disabled value="{{ $profil->email }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $profil->no_hp) }}"
                           class="form-control @error('no_hp') is-invalid @enderror">
                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2" class="form-control">{{ old('alamat', $profil->alamat) }}</textarea>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">
                        Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-ch w-100 py-2">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
