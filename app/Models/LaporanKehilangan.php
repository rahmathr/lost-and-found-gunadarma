<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanKehilangan extends Model
{
    protected $table = 'laporan_kehilangan';

    protected $primaryKey = 'id_laporan';

    public $timestamps = false;

    protected $fillable = [
        'id_kampus',
        'id_pelapor',
        'nama_barang',
        'deskripsi',
        'tanggal_hilang',
        'lokasi_hilang',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_hilang' => 'date',
        ];
    }

    public function foto(): HasMany
    {
        return $this->hasMany(FotoLaporanKehilangan::class, 'id_laporan', 'id_laporan')->orderBy('urutan');
    }

    public function kampus(): BelongsTo
    {
        return $this->belongsTo(
            Kampus::class,
            'id_kampus',
            'id_kampus'
        );
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(
            PelaporKehilangan::class,
            'id_pelapor',
            'id_pelapor'
        );
    }
}
