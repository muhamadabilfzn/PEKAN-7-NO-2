<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $table = 'assignments';
    protected $fillable = [
        'report_id',
        'officer_id',
        'assigned_by',
        'catatan',
        'status',
        'assigned_at',
        'selesai_at',
    ];
    protected $casts = [
        'assigned_at' => 'datetime',
        'selesai_at'  => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(WasteReport::class, 'report_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(Officer::class, 'officer_id');
    }
}
