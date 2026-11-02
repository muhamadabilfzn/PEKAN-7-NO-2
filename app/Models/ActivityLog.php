<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'ip_address',
    ];

    public static function catat(?int $userId, string $aksi, string $deskripsi = '', ?string $ip = null): self
    {
        return static::create([
            'user_id'    => $userId,
            'aksi'       => $aksi,
            'deskripsi'  => $deskripsi,
            'ip_address' => $ip,
        ]);
    }
}
