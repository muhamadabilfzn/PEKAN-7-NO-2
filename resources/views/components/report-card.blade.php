@props(['report'])
<div class="report-card h-100">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <x-category-badge :category="$report->category" />
        <x-status-badge :status="$report->status" />
    </div>
    <p class="small mb-2">{{ \Illuminate\Support\Str::limit($report->deskripsi, 80) }}</p>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted"><i class="fa-solid fa-user me-1"></i>{{ $report->user->nama_lengkap }}</small>
        <a href="{{ route('laporan.show', $report->id) }}" class="btn btn-sm btn-outline-secondary">
            Detail <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <small class="text-muted d-block mt-2">
        <i class="fa-solid fa-clock me-1"></i>{{ $report->created_at->format('d M Y, H:i') }}
    </small>
</div>
