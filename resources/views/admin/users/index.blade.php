@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0">Manajemen User</h5>
            <small class="text-muted">Kelola seluruh akun pengguna sistem CleanHub</small>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-ch btn-sm px-3">
            <i class="fa-solid fa-user-plus me-1"></i>Tambah User
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <select name="role" class="form-select form-select-sm" aria-label="Role">
                        <option value="">Semua Role</option>
                        <option value="admin"      @selected(($filter['role'] ?? '') === 'admin')>Administrator</option>
                        <option value="petugas"    @selected(($filter['role'] ?? '') === 'petugas')>Petugas</option>
                        <option value="masyarakat" @selected(($filter['role'] ?? '') === 'masyarakat')>Masyarakat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm" aria-label="Status">
                        <option value="">Semua Status</option>
                        <option value="aktif"    @selected(($filter['status'] ?? '') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(($filter['status'] ?? '') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Cari nama..."
                           value="{{ $filter['keyword'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-ch w-100"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>User</th><th>Email</th><th>No. HP</th><th>Role</th><th>Status</th><th>Daftar</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @php $roleColor = ['admin' => 'danger', 'petugas' => 'warning', 'masyarakat' => 'info']; @endphp
                    @forelse ($users as $u)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="avatar">{{ strtoupper(substr($u->nama_lengkap, 0, 1)) }}</span>
                                    <div>
                                        <div class="fw-semibold small">{{ $u->nama_lengkap }}</div>
                                        <div class="text-muted" style="font-size:.72rem">&#64;{{ $u->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $u->email }}</td>
                            <td class="small text-muted">{{ $u->no_hp ?? '-' }}</td>
                            <td><span class="badge text-bg-{{ $roleColor[$u->role->name] ?? 'secondary' }}">{{ $u->role->display_name }}</span></td>
                            <td>
                                <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Ubah status user ini?')">
                                    @csrf
                                    <button type="submit" class="badge border-0 {{ $u->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($u->status) }}
                                    </button>
                                </form>
                            </td>
                            <td class="small text-muted">{{ $u->created_at->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm" style="background:#fff3e0;color:#e65100" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                @if ((int) $u->id !== (int) session('user_id'))
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus user ini permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background:#ffebee;color:#c62828" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada user ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
