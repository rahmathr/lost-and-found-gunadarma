<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangDitemukan extends Model
{
    protected $table = 'barang_ditemukan';

    protected $primaryKey = 'id_barang';

    public $timestamps = false;

    protected $fillable = [
        'id_kampus',
        'sumber_penerimaan',
        'id_admin_validator',
        'id_satpam',
        'id_admin_penerima',
        'nama_publik',
        'kategori',
        'deskripsi_publik',
        'tanggal_ditemukan',
        'lokasi_ditemukan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ditemukan' => 'date',
        ];
    }

    public function kampus(): BelongsTo
    {
        return $this->belongsTo(
            Kampus::class,
            'id_kampus',
            'id_kampus'
        );
    }

    public function adminValidator(): BelongsTo
    {
        return $this->belongsTo(
            AdminKampus::class,
            'id_admin_validator',
            'id_admin'
        );
    }

    public function satpam(): BelongsTo
    {
        return $this->belongsTo(
            Satpam::class,
            'id_satpam',
            'id_satpam'
        );
    }

    public function adminPenerima(): BelongsTo
    {
        return $this->belongsTo(
            AdminKampus::class,
            'id_admin_penerima',
            'id_admin'
        );
    }

    public function foto(): HasMany
    {
        return $this->hasMany(
            FotoBarangDitemukan::class,
            'id_barang',
            'id_barang'
        )->orderBy('urutan');
    }

    public function klaim(): HasMany
    {
        return $this->hasMany(
            Klaim::class,
            'id_barang',
            'id_barang'
        );
    }
}
