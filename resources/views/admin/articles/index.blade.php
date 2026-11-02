@extends('layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0">Manajemen Artikel & Edukasi</h5>
            <small class="text-muted">Kelola konten edukasi lingkungan untuk publik</small>
        </div>
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-ch btn-sm px-3">
            <i class="fa-solid fa-plus me-1"></i>Tulis Artikel
        </a>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($artikel as $a)
                        <tr>
                            <td>
                                @if ($a->thumbnail_url)
                                    <img src="{{ $a->thumbnail_url }}" alt="Thumbnail {{ $a->judul }}" class="rounded border" style="width:64px;height:48px;object-fit:cover">
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="fw-semibold small">{{ $a->judul }}</td>
                            <td><span class="badge bg-info">{{ $a->kategori_label }}</span></td>
                            <td class="small text-muted">{{ $a->penulis->nama_lengkap ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.artikel.toggle', $a->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="badge border-0 {{ $a->is_published ? 'bg-success' : 'bg-secondary' }}"
                                            title="Klik untuk ubah status">
                                        {{ $a->is_published ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="small text-muted">{{ $a->created_at->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.artikel.edit', $a->id) }}" class="btn btn-sm" style="background:#fff3e0;color:#e65100" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $a->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#ffebee;color:#c62828" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada artikel.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
