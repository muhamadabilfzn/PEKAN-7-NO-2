{{-- Form filter laporan. Parameter: $action (url), $filter (array), $categories (collection) --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ $action }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold" for="fStatus">Status</label>
                <select id="fStatus" name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach (\App\Models\WasteReport::STATUSES as $s)
                        <option value="{{ $s }}" @selected(($filter['status'] ?? '') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold" for="fKategori">Kategori</label>
                <select id="fKategori" name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected((string) ($filter['kategori'] ?? '') === (string) $c->id)>{{ $c->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold" for="fKeyword">Cari</label>
                <input id="fKeyword" type="text" name="keyword" class="form-control form-control-sm"
                       placeholder="Kata kunci deskripsi..." value="{{ $filter['keyword'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-ch w-100">
                    <i class="fa-solid fa-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>
