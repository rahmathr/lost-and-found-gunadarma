<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satpam extends Model
{
    protected $table = 'satpam';

    protected $primaryKey = 'id_satpam';

    public $timestamps = false;

    protected $fillable = [
        'id_kampus',
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

    public function barangDitemukan(): HasMany
    {
        return $this->hasMany(
            BarangDitemukan::class,
            'id_satpam',
            'id_satpam'
        );
    }

    public function riwayatAktivitas(): HasMany
    {
        return $this->hasMany(
            RiwayatAktivitas::class,
            'id_satpam',
            'id_satpam'
        );
    }
}
