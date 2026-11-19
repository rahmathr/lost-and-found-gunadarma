<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminKampus extends Model
{
    protected $table = 'admin_kampus';

    protected $primaryKey = 'id_admin';

    public $timestamps = false;

    protected $fillable = [
        'id_kampus',
        'id_super_admin_pembuat',
        'nama',
        'email',
        'password_hash',
    ];

    public function kampus(): BelongsTo
    {
        return $this->belongsTo(
            Kampus::class,
            'id_kampus',
            'id_kampus'
        );
    }

    public function superAdminPembuat(): BelongsTo
    {
        return $this->belongsTo(
            SuperAdmin::class,
            'id_super_admin_pembuat',
            'id_super_admin'
        );
    }

    public function barangDivalidasi(): HasMany
    {
        return $this->hasMany(
            BarangDitemukan::class,
            'id_admin_validator',
            'id_admin'
        );
    }

    public function barangDiterima(): HasMany
    {
        return $this->hasMany(
            BarangDitemukan::class,
            'id_admin_penerima',
            'id_admin'
        );
    }

    public function klaim(): HasMany
    {
        return $this->hasMany(
            Klaim::class,
            'id_admin',
            'id_admin'
        );
    }

    public function penyerahan(): HasMany
    {
        return $this->hasMany(
            Penyerahan::class,
            'id_admin',
            'id_admin'
        );
    }

    public function riwayatAktivitas(): HasMany
    {
        return $this->hasMany(
            RiwayatAktivitas::class,
            'id_admin',
            'id_admin'
        );
    }
}
