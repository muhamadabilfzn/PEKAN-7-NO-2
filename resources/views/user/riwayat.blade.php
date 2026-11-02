@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-clock-rotate-left me-2" style="color:var(--primary)"></i>Riwayat Laporan Saya</h5>
        <a href="{{ route('laporan.create') }}" class="btn btn-sm btn-ch px-3"><i class="fa-solid fa-plus me-1"></i>Lapor</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Kategori</th><th>Deskripsi</th><th>Lokasi</th><th>Status</th><th>Tanggal</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $l)
                        <tr>
                            <td class="text-muted small">#{{ $l->id }}</td>
                            <td><x-category-badge :category="$l->category" :icon="false" /></td>
                            <td class="small">{{ \Illuminate\Support\Str::limit($l->deskripsi, 50) }}</td>
                            <td class="small text-muted">{{ $l->alamat_detail ? \Illuminate\Support\Str::limit($l->alamat_detail, 30) : '-' }}</td>
                            <td><x-status-badge :status="$l->status" /></td>
                            <td class="small text-muted">{{ $l->created_at->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('laporan.show', $l->id) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                @if ($l->status === 'diajukan')
                                    <form action="{{ route('laporan.destroy', $l->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
