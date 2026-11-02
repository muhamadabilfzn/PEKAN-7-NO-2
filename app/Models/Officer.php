<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Officer extends Model
{
    protected $table = 'officers';
    protected $fillable = [
        'user_id',
        'area_kerja',
        'saldo',
        'status',
    ];
    protected $casts = ['saldo' => 'float'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'officer_id');
    }
}
