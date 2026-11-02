@extends('layouts.app')

@section('title', 'Pusat Bantuan')

@section('content')
<div class="container py-5" style="max-width:680px">
    <h2 class="fw-bold mb-1">Pusat Bantuan</h2>
    <p class="text-muted mb-4">Ada pertanyaan atau kendala? Hubungi kami.</p>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Kirim Pesan</h5>
            <form action="{{ route('bantuan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', session('nama')) }}"
                               class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', session('email')) }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="subjek">Subjek</label>
                        <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="5" class="form-control @error('pesan') is-invalid @enderror">{{ old('pesan') }}</textarea>
                        @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-ch px-4 mt-3">
                    <i class="fa-solid fa-paper-plane me-1"></i>Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    @php
        $kontak = [
            ['fa-envelope', 'Email',           'cleanhub@sisteminformasikotacerdas.id'],
            ['fa-clock',    'Jam Operasional', 'Sen–Jum, 08.00–16.00 WIB'],
        ];
    @endphp
    <div class="row g-3">
        @foreach ($kontak as [$icon, $judul, $isi])
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box"><i class="fa-solid {{ $icon }}"></i></div>
                        <div>
                            <div class="fw-semibold small">{{ $judul }}</div>
                            <div class="text-muted small">{{ $isi }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
