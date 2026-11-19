<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelaporKehilangan extends Model
{
    protected $table = 'pelapor_kehilangan';

    protected $primaryKey = 'id_pelapor';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function laporanKehilangan(): HasMany
    {
        return $this->hasMany(
            LaporanKehilangan::class,
            'id_pelapor',
            'id_pelapor'
        );
    }

    public function klaim(): HasMany
    {
        return $this->hasMany(
            Klaim::class,
            'id_pelapor',
            'id_pelapor'
        );
    }
}
