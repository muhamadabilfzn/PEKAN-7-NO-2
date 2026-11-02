@extends('layouts.app')

@section('title', 'Semua Tugas Saya')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-2" style="color:var(--primary)"></i>Semua Tugas Saya</h5>
        <a href="{{ route('officer.dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Kategori</th><th>Deskripsi</th><th>Lokasi</th><th>Status</th><th>Ditugaskan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($semuaTugas as $t)
                        <tr>
                            <td class="text-muted small">#{{ $t->report_id }}</td>
                            <td><x-category-badge :category="$t->report->category" :icon="false" /></td>
                            <td class="small">{{ \Illuminate\Support\Str::limit($t->report->deskripsi, 50) }}</td>
                            <td class="small text-muted">{{ $t->report->alamat_detail ? \Illuminate\Support\Str::limit($t->report->alamat_detail, 30) : '-' }}</td>
                            <td><x-status-badge :status="$t->status" /></td>
                            <td class="small text-muted">{{ $t->assigned_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($t->status === 'pending')
                                    <form action="{{ route('officer.ambil', $t->id) }}" method="POST" onsubmit="return confirm('Ambil tugas ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ch px-3"><i class="fa-solid fa-hand me-1"></i>Ambil</button>
                                    </form>
                                @elseif ($t->status === 'diterima')
                                    <form action="{{ route('officer.selesai', $t->id) }}" method="POST" onsubmit="return confirm('Tandai selesai?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-check me-1"></i>Selesai</button>
                                    </form>
                                @else
                                    <span class="text-success small"><i class="fa-solid fa-check-double me-1"></i>+Rp15.000</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada tugas yang diberikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
