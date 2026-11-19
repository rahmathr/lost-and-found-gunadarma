<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Klaim extends Model
{
    protected $table = 'klaim';

    protected $primaryKey = 'id_klaim';

    public $timestamps = false;

    protected $fillable = [
        'id_barang',
        'id_pelapor',
        'id_admin',
        'tanggal_klaim',
        'keterangan_privat',
        'status',
        'catatan_admin',
        'bukti_tambahan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_klaim' => 'datetime',
        ];
    }

    /**
     * Relasi ke Barang Ditemukan.
     */
    public function barangDitemukan(): BelongsTo
    {
        return $this->belongsTo(
            BarangDitemukan::class,
            'id_barang',
            'id_barang'
        );
    }

    /**
     * Relasi ke Pelapor Kehilangan.
     */
    public function pelaporKehilangan(): BelongsTo
    {
        return $this->belongsTo(
            PelaporKehilangan::class,
            'id_pelapor',
            'id_pelapor'
        );
    }

    /**
     * Relasi ke Admin Kampus.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            AdminKampus::class,
            'id_admin',
            'id_admin'
        );
    }

    /**
     * Relasi ke Penyerahan.
     */
    public function penyerahan(): HasOne
    {
        return $this->hasOne(
            Penyerahan::class,
            'id_klaim',
            'id_klaim'
        );
    }
}
