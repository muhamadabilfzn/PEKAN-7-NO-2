<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteReport extends Model
{
    public const STATUSES = ['diajukan', 'diverifikasi', 'diproses', 'ditangani', 'selesai'];
    public const IURAN    = 15000;

    protected $table = 'waste_reports';
    protected $fillable = [
        'user_id',
        'category_id',
        'location_id',
        'deskripsi',
        'status',
        'latitude',
        'longitude',
        'alamat_detail',
        'iuran',
        'is_paid',
    ];
    protected $casts = [
        'iuran'     => 'float',
        'is_paid'   => 'boolean',
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WasteCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReportImage::class, 'report_id');
    }

    /** Filter status, kategori, dan kata kunci (dipakai halaman publik & admin). */
    public function scopeFilter(Builder $query, array $f): Builder
    {
        return $query
            ->when(! empty($f['status']) && $f['status'] !== 'all', fn ($q) => $q->where('status', $f['status']))
            ->when(! empty($f['kategori']), fn ($q) => $q->where('category_id', $f['kategori']))
            ->when(! empty($f['keyword']), fn ($q) => $q->where('deskripsi', 'like', '%' . $f['keyword'] . '%'));
    }

    /** Ringkasan angka untuk beranda & dashboard. */
    public static function statistik(): array
    {
        $total   = static::count();
        $selesai = static::where('status', 'selesai')->count();

        return [
            'total'   => $total,
            'selesai' => $selesai,
            'aktif'   => $total - $selesai,
        ];
    }

    public static function chartPerBulan()
    {
        return static::selectRaw('MONTH(created_at) AS bulan, COUNT(*) AS total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('bulan')
            ->get();
    }

    public static function chartPerStatus()
    {
        return static::selectRaw('status, COUNT(*) AS total')->groupBy('status')->get();
    }

    public static function chartPerArea(int $limit = 5)
    {
        return static::join('locations', 'locations.id', '=', 'waste_reports.location_id')
            ->whereNotNull('locations.kecamatan')
            ->selectRaw('locations.kecamatan AS kecamatan, COUNT(waste_reports.id) AS total')
            ->groupBy('locations.kecamatan')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }
}
