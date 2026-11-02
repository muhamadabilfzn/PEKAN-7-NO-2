<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $table = 'support_messages';
    protected $fillable = [
        'nama',
        'email',
        'subjek',
        'pesan',
    ];
}
