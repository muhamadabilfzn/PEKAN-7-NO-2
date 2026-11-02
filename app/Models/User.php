<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'role_id',
        'nama_lengkap',
        'username',
        'email',
        'password',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'foto_profil',
        'status',
    ];
    protected $hidden = ['password'];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function officer(): HasOne
    {
        return $this->hasOne(Officer::class, 'user_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(WasteReport::class, 'user_id');
    }
}
