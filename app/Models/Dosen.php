<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nuptk',
        'jabatan_fungsional',
        'ikatan_kerja',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pengajarans(): HasMany
    {
        return $this->hasMany(Pengajaran::class);
    }

    public function penelitians(): HasMany
    {
        return $this->hasMany(Penelitian::class);
    }

    public function pengabdians(): HasMany
    {
        return $this->hasMany(Pengabdian::class);
    }

    public function penunjangs(): HasMany
    {
        return $this->hasMany(Penunjang::class);
    }
}
