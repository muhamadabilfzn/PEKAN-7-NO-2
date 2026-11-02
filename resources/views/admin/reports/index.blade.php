@extends('layouts.app')

@section('title', 'Manajemen Laporan')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <div class="mb-4">
        <h5 class="fw-bold mb-0">Manajemen Laporan Sampah</h5>
        <small class="text-muted">Verifikasi, assign petugas, dan update status laporan</small>
    </div>

    @include('partials.report-filter', ['action' => route('admin.laporan.index')])

    <div class="panel">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>#ID</th><th>Pelapor</th><th>Kategori</th><th>Lokasi</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($reports as $r)
                        <tr>
                            <td><span class="fw-bold text-muted small">#{{ $r->id }}</span></td>
                            <td>
                                <div class="fw-semibold small">{{ $r->user->nama_lengkap }}</div>
                                <div class="text-muted" style="font-size:.72rem">{{ $r->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td><x-category-badge :category="$r->category" /></td>
                            <td class="small text-muted" style="max-width:180px">
                                @if ($r->alamat_detail)
                                    {{ \Illuminate\Support\Str::limit($r->alamat_detail, 40) }}
                                @else
                                    <span class="text-danger">Belum ada</span>
                                @endif
                            </td>
                            <td><x-status-badge :status="$r->status" class="px-2 py-1" /></td>
                            <td class="small text-muted">{{ $r->created_at->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.laporan.show', $r->id) }}" class="btn btn-sm" style="background:#e3f2fd;color:#1565c0" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                @if ($r->status === 'diajukan')
                                    <form action="{{ route('admin.laporan.verify', $r->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Verifikasi laporan ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm" style="background:#e8f5e9;color:#2e7d32" title="Verifikasi">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.laporan.destroy', $r->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus laporan #{{ $r->id }}? Data tidak bisa dikembalikan!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#ffebee;color:#c62828" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada laporan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reports->hasPages())
            <div class="p-3 d-flex justify-content-center">{{ $reports->links() }}</div>
        @endif
    </div>
</div>
@endsection
