@extends('layouts.app')

@section('title', isset($editArtikel) ? 'Edit Artikel' : 'Tulis Artikel')

@section('content')
<div class="container py-4" style="max-width:820px">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">{{ isset($editArtikel) ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h5>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST"
                  action="{{ isset($editArtikel) ? route('admin.artikel.update', $editArtikel->id) : route('admin.artikel.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @isset($editArtikel)
                    @method('PUT')
                @endisset

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="judul">Judul Artikel</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $editArtikel->judul ?? '') }}"
                           class="form-control @error('judul') is-invalid @enderror">
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                        @foreach (\App\Models\Article::KATEGORI as $val => $label)
                            <option value="{{ $val }}" @selected(old('kategori', $editArtikel->kategori ?? '') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="konten">Konten</label>
                    <textarea id="konten" name="konten" rows="10"
                              class="form-control @error('konten') is-invalid @enderror">{{ old('konten', $editArtikel->konten ?? '') }}</textarea>
                    @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="thumbnail">Gambar Thumbnail <span class="text-muted fw-normal">(opsional)</span></label>

                    @if (isset($editArtikel) && $editArtikel->thumbnail_url)
                        <div class="mb-2">
                            <img src="{{ $editArtikel->thumbnail_url }}" alt="Thumbnail saat ini" class="rounded border" style="max-height:140px">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_thumbnail" id="hapusThumb" value="1" @checked(old('hapus_thumbnail'))>
                                <label class="form-check-label small" for="hapusThumb">Hapus gambar ini</label>
                            </div>
                        </div>
                    @endif

                    <input type="file" id="thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                           class="form-control @error('thumbnail') is-invalid @enderror">
                    <div class="form-text">JPG, JPEG, atau PNG. Maksimal 2 MB.{{ isset($editArtikel) && $editArtikel->thumbnail ? ' Pilih file baru untuk mengganti gambar lama.' : '' }}</div>
                    @error('thumbnail')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="isPublished" value="1"
                           @checked(old('is_published', isset($editArtikel) ? $editArtikel->is_published : true))>
                    <label class="form-check-label" for="isPublished">Publikasikan sekarang</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-ch px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i>{{ isset($editArtikel) ? 'Update Artikel' : 'Simpan Artikel' }}
                    </button>
                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-secondary" style="border-radius:50px">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
