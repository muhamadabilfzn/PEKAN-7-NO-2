<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    public const KATEGORI = [
        'pemilahan'   => 'Pemilahan Sampah',
        'daur_ulang'  => 'Daur Ulang',
        'kebersihan'  => 'Kebersihan Lingkungan',
        'pengelolaan' => 'Pengelolaan Sampah',
    ];

    protected const IKON = [
        'pemilahan'   => 'fa-recycle',
        'daur_ulang'  => 'fa-arrows-rotate',
        'kebersihan'  => 'fa-broom',
        'pengelolaan' => 'fa-trash-arrow-up',
    ];

    protected $table = 'articles';
    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'thumbnail',
        'konten',
        'kategori',
        'is_published',
    ];
    protected $casts = ['is_published' => 'boolean'];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', 1);
    }

    /** URL publik thumbnail (null jika artikel tidak punya gambar). Butuh php artisan storage:link. */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI[$this->kategori] ?? 'Edukasi';
    }

    public function getKategoriIkonAttribute(): string
    {
        return self::IKON[$this->kategori] ?? 'fa-leaf';
    }

    /** Slug unik (kolom slug punya unique index). */
    public static function buatSlug(string $judul, ?int $abaikanId = null): string
    {
        $dasar = Str::slug($judul) ?: 'artikel';
        $slug  = $dasar;
        $i     = 2;

        while (static::where('slug', $slug)->when($abaikanId, fn ($q) => $q->where('id', '!=', $abaikanId))->exists()) {
            $slug = $dasar . '-' . $i++;
        }

        return $slug;
    }
}
