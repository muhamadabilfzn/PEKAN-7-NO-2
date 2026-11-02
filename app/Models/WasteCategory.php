<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WasteCategory extends Model
{
    protected $table = 'waste_categories';
    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
        'warna',
    ];

    public function reports(): HasMany
    {
        return $this->hasMany(WasteReport::class, 'category_id');
    }
}
