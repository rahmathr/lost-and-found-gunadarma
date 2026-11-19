<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatAktivitas extends Model
{
    protected $table = 'riwayat_aktivitas';

    protected $primaryKey = 'id_aktivitas';

    public $timestamps = false;

    protected $fillable = [
        'id_super_admin',
        'id_admin',
        'id_satpam',
        'tindakan',
        'waktu',
        'referensi_jenis',
        'referensi_id',
    ];

    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
        ];
    }

    public function superAdmin(): BelongsTo
    {
        return $this->belongsTo(
            SuperAdmin::class,
            'id_super_admin',
            'id_super_admin'
        );
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            AdminKampus::class,
            'id_admin',
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
}
