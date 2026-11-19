<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuperAdmin extends Model
{
    protected $table = 'super_admin';

    protected $primaryKey = 'id_super_admin';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password_hash',
    ];

    public function adminKampusDibuat(): HasMany
    {
        return $this->hasMany(
            AdminKampus::class,
            'id_super_admin_pembuat',
            'id_super_admin'
        );
    }

    public function riwayatAktivitas(): HasMany
    {
        return $this->hasMany(
            RiwayatAktivitas::class,
            'id_super_admin',
            'id_super_admin'
        );
    }
}
