<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengabdian extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'tipe',
        'judul',
        'tahun',
        'sumber_biaya',
        'jumlah_biaya',
        'link',
        'file',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'jumlah_biaya' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
