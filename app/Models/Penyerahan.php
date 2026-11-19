<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penyerahan extends Model
{
    protected $table = 'penyerahan';

    protected $primaryKey = 'id_penyerahan';

    public $timestamps = false;

    protected $fillable = [
        'id_klaim',
        'id_admin',
        'tanggal_penyerahan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penyerahan' => 'datetime',
        ];
    }

    public function klaim(): BelongsTo
    {
        return $this->belongsTo(
            Klaim::class,
            'id_klaim',
            'id_klaim'
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
}
