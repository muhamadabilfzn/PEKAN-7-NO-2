@props(['value', 'label', 'color' => '#00bcd4', 'icon' => null])
<div class="stat-card" style="border-left-color: {{ $color }}">
    <div class="val" style="color: {{ $color }}">{{ $value }}</div>
    <div class="text-muted small">
        @if ($icon)<i class="fa-solid {{ $icon }} me-1"></i>@endif{{ $label }}
    </div>
</div>
