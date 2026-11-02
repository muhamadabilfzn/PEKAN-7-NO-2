@props(['category', 'icon' => true])
<span {{ $attributes->merge(['class' => 'badge']) }} style="background: {{ $category->warna }}">
    @if ($icon)<i class="fa-solid {{ $category->icon }} me-1"></i>@endif{{ $category->nama }}
</span>
