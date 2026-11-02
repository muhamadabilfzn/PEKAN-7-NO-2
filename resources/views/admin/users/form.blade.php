@extends('layouts.app')

@section('title', isset($editUser) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="container py-4" style="max-width:820px">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">{{ isset($editUser) ? 'Edit User' : 'Tambah User Baru' }}</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST"
                  action="{{ isset($editUser) ? route('admin.users.update', $editUser->id) : route('admin.users.store') }}">
                @csrf
                @isset($editUser)
                    @method('PUT')
                @endisset

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $editUser->nama_lengkap ?? '') }}"
                               class="form-control @error('nama_lengkap') is-invalid @enderror">
                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $editUser->username ?? '') }}"
                               class="form-control @error('username') is-invalid @enderror" @isset($editUser) readonly @endisset>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $editUser->email ?? '') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="no_hp">No. HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $editUser->no_hp ?? '') }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="password">
                            Password
                            @isset($editUser)<small class="text-muted fw-normal">(kosongkan jika tidak diubah)</small>@endisset
                        </label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="role_id">Role</label>
                        <select id="role_id" name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    @selected((int) old('role_id', $editUser->role_id ?? 3) === (int) $role->id)>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @isset($editUser)
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="status">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="aktif"    @selected(old('status', $editUser->status) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status', $editUser->status) === 'nonaktif')>Nonaktif</option>
                            </select>
                        </div>
                    @endisset
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-ch px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i>{{ isset($editUser) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" style="border-radius:50px">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
