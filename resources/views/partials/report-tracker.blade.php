{{-- Tracking status laporan. Parameter: $status (string) --}}
@php
    $allStatus  = \App\Models\WasteReport::STATUSES;
    $currentIdx = array_search($status, $allStatus);
@endphp
<div class="d-flex align-items-center gap-1 flex-wrap">
    @foreach ($allStatus as $i => $s)
        <div class="tracker-step">
            <div class="tracker-dot" style="background: {{ $i <= $currentIdx ? 'var(--primary)' : '#dee2e6' }}">
                @if ($i < $currentIdx)
                    <i class="fa-solid fa-check"></i>
                @elseif ($i === $currentIdx)
                    <i class="fa-solid fa-circle-dot"></i>
                @else
                    <i class="fa-solid fa-circle" style="opacity:.3;font-size:.6rem"></i>
                @endif
            </div>
            <div style="font-size:.7rem; color: {{ $i <= $currentIdx ? 'var(--primary)' : '#aaa' }}; font-weight: {{ $i === $currentIdx ? 700 : 400 }}">
                {{ ucfirst($s) }}
            </div>
        </div>
        @if (! $loop->last)
            <div class="tracker-line" style="background: {{ $i < $currentIdx ? 'var(--primary)' : '#dee2e6' }}"></div>
        @endif
    @endforeach
</div>
