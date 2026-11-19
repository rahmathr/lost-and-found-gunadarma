<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kampus extends Model
{
    protected $table = 'kampus';

    protected $primaryKey = 'id_kampus';

    public $timestamps = false;

    protected $fillable = [
        'nama_kampus',
        'alamat',
    ];

    public function adminKampus(): HasMany
    {
        return $this->hasMany(AdminKampus::class, 'id_kampus', 'id_kampus');
    }

    public function satpam(): HasMany
    {
        return $this->hasMany(Satpam::class, 'id_kampus', 'id_kampus');
    }

    public function barangDitemukan(): HasMany
    {
        return $this->hasMany(BarangDitemukan::class, 'id_kampus', 'id_kampus');
    }

    public function laporanKehilangan(): HasMany
    {
        return $this->hasMany(LaporanKehilangan::class, 'id_kampus', 'id_kampus');
    }
}
