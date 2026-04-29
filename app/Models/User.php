<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class);
    }

    public function pengajaranDibuat(): HasMany
    {
        return $this->hasMany(Pengajaran::class, 'created_by');
    }

    public function pengajaranDisetujui(): HasMany
    {
        return $this->hasMany(Pengajaran::class, 'approved_by');
    }


    public function bukuDibuat(): HasMany
    {
        return $this->hasMany(Buku::class, 'created_by');
    }

    public function bukuDisetujui(): HasMany
    {
        return $this->hasMany(Buku::class, 'approved_by');
    }

    public function penelitianDibuat(): HasMany
    {
        return $this->hasMany(Penelitian::class, 'created_by');
    }

    public function penelitianDisetujui(): HasMany
    {
        return $this->hasMany(Penelitian::class, 'approved_by');
    }

    public function pengabdianDibuat(): HasMany
    {
        return $this->hasMany(Pengabdian::class, 'created_by');
    }

    public function pengabdianDisetujui(): HasMany
    {
        return $this->hasMany(Pengabdian::class, 'approved_by');
    }

    public function penunjangDibuat(): HasMany
    {
        return $this->hasMany(Penunjang::class, 'created_by');
    }

    public function penunjangDisetujui(): HasMany
    {
        return $this->hasMany(Penunjang::class, 'approved_by');
    }
}
