<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    protected $table = 'report_images';
    protected $fillable = [
        'report_id',
        'file_path',
        'file_type',
        'is_bukti_selesai',
        'uploaded_at',
    ];

    protected $casts = [
        'is_bukti_selesai' => 'boolean',
        'uploaded_at'      => 'datetime',
    ];

    public function report(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WasteReport::class, 'report_id');
    }
}
