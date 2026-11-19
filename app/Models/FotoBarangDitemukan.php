<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoBarangDitemukan extends Model
{
    protected $table = 'foto_barang_ditemukan';

    protected $primaryKey = 'id_foto';

    public $timestamps = false;

    protected $fillable = [
        'id_barang',
        'path_foto',
        'is_utama',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'is_utama' => 'boolean',
        ];
    }

    public function barangDitemukan(): BelongsTo
    {
        return $this->belongsTo(
            BarangDitemukan::class,
            'id_barang',
            'id_barang'
        );
    }
}
