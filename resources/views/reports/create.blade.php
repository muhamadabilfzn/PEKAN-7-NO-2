@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
@include('partials.leaflet')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" style="color:var(--primary)">Dashboard</a></li>
                    <li class="breadcrumb-item active">Buat Laporan</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header card-header-ch">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i>Laporkan Titik Sampah</h5>
                    <small class="opacity-75">Isi form berikut dengan detail dan akurat</small>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                        @csrf

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kategori Sampah <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                @foreach ($categories as $cat)
                                    <div class="col-6 col-md-4">
                                        <input type="radio" class="btn-check" name="category_id" id="cat{{ $cat->id }}"
                                               value="{{ $cat->id }}" @checked((string) old('category_id') === (string) $cat->id)>
                                        <label class="btn btn-outline-secondary w-100 py-3" for="cat{{ $cat->id }}">
                                            <i class="fa-solid {{ $cat->icon }} fa-lg d-block mb-1" style="color:{{ $cat->warna }}"></i>
                                            <small>{{ $cat->nama }}</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('category_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Sampah</label>
                            <div class="border rounded p-3 text-center" id="photoDropZone" style="cursor:pointer;border-style:dashed !important">
                                <img id="photoPreview" src="" alt="Pratinjau" class="mb-2 w-100" style="display:none;max-height:200px;border-radius:8px;object-fit:cover">
                                <div id="previewText">
                                    <i class="fa-solid fa-camera fa-3x mb-2" style="color:#00bcd4;opacity:.6"></i>
                                    <p class="mb-0 text-muted">Klik untuk memilih foto</p>
                                    <small class="text-muted">JPG, PNG, GIF – Maks. 5MB</small>
                                </div>
                                <input type="file" name="foto" id="reportPhoto" accept="image/*" class="d-none">
                            </div>
                            @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="deskripsi">Deskripsi Masalah <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" maxlength="500"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Ceritakan situasi sampah yang Anda temukan secara detail...">{{ old('deskripsi') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                <small class="text-muted ms-auto"><span id="charCount">0</span>/500</small>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="reportLocation">Lokasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-location-dot" style="color:#00bcd4"></i></span>
                                <input type="text" name="alamat" id="reportLocation" value="{{ old('alamat') }}"
                                       class="form-control @error('alamat') is-invalid @enderror"
                                       placeholder="Klik GPS atau ketik alamat manual">
                                <button type="button" class="btn btn-outline-secondary" id="gpsBtn">
                                    <i class="fa-solid fa-crosshairs me-1"></i>GPS
                                </button>
                            </div>
                            <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
                            <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">
                            @error('alamat')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                            <div id="miniMap" class="mt-2 rounded" style="height:200px;display:none;background:#e9ecef">
                                <div id="leafletMini" style="height:100%;border-radius:8px"></div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-ch btn-lg fw-bold">
                                <i class="fa-solid fa-paper-plane me-2"></i>Kirim Laporan
                            </button>
                            <a href="{{ route('user.riwayat') }}" class="btn btn-outline-secondary btn-lg" style="border-radius:50px">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const deskripsi = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    const updateCount = () => charCount.textContent = deskripsi.value.length;
    deskripsi.addEventListener('input', updateCount);
    updateCount();

    // Pratinjau foto
    const photoInput = document.getElementById('reportPhoto');
    document.getElementById('photoDropZone').addEventListener('click', () => photoInput.click());
    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('photoPreview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('previewText').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    // GPS + peta mini
    let miniMap = null;
    function showMiniMap(lat, lng) {
        document.getElementById('miniMap').style.display = 'block';
        if (!miniMap) {
            miniMap = L.map('leafletMini').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(miniMap);
        }
        L.marker([lat, lng]).addTo(miniMap).bindPopup('Lokasi laporan').openPopup();
        miniMap.setView([lat, lng], 16);
    }

    document.getElementById('gpsBtn').addEventListener('click', function () {
        const btn = this;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mengambil...';
        btn.disabled = true;

        const reset = () => { btn.innerHTML = '<i class="fa-solid fa-crosshairs me-1"></i>GPS'; btn.disabled = false; };

        if (!navigator.geolocation) { reset(); return; }

        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude.toFixed(7);
            const lng = pos.coords.longitude.toFixed(7);
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('reportLocation').value = `Koordinat: ${lat}, ${lng} (GPS Akurat)`;
            reset();
            showMiniMap(lat, lng);
        }, () => {
            // GPS ditolak/gagal: isi lokasi contoh wilayah Bandung
            document.getElementById('reportLocation').value = 'Jl. Parakan Saat 2, Cisaranten Endah, Arcamanik, Bandung';
            document.getElementById('lat').value = -6.9175;
            document.getElementById('lng').value = 107.6771;
            reset();
        });
    });
</script>
@endpush
