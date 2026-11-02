<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') – CleanHub</title>

    {{-- CSS bersama untuk seluruh halaman --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/cleanhub.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

    {{-- HEADER + MENU NAVIGASI --}}
    @include('partials.header')

    {{-- PESAN FLASH (sukses / error) --}}
    @include('partials.flash')

    {{-- ISI HALAMAN: diisi oleh setiap view lewat @section('content') --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
