@props(['icon' => 'fa-inbox', 'message' => 'Tidak ada data.'])
<div class="text-center text-muted py-5">
    <i class="fa-solid {{ $icon }} fa-3x mb-3 opacity-25"></i>
    <p class="mb-0">{{ $message }}</p>
    {{ $slot }}
</div>
