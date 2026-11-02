<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'is_read',
    ];
    protected $casts = [
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
    ];

    public static function kirim(int $userId, string $judul, string $pesan, string $tipe = 'info'): self
    {
        return static::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
        ]);
    }
}
