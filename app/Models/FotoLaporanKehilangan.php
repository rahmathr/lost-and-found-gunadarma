<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoLaporanKehilangan extends Model
{
    protected $table = 'foto_laporan_kehilangan';
    protected $primaryKey = 'id_foto_laporan';
    public $timestamps = false;

    protected $fillable = ['id_laporan', 'path_foto', 'urutan'];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanKehilangan::class, 'id_laporan', 'id_laporan');
    }
}
