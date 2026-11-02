@props(['status'])
<span {{ $attributes->merge(['class' => 'badge badge-' . $status]) }}>{{ ucfirst($status) }}</span>
