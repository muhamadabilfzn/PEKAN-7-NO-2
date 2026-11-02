<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'latitude',
        'longitude',
        'kecamatan',
        'kelurahan',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function reports(): HasMany
    {
        return $this->hasMany(WasteReport::class, 'location_id');
    }
}
