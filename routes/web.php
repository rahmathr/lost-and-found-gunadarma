<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;

use App\Http\Controllers\SuperAdmin\KampusController;
use App\Http\Controllers\SuperAdmin\AdminKampusController;
use App\Http\Controllers\SuperAdmin\RiwayatAktivitasController;

use App\Http\Controllers\Admin\SatpamController;
use App\Http\Controllers\Admin\ValidasiBarangController;
use App\Http\Controllers\Admin\BarangDiterimaController;
use App\Http\Controllers\Admin\ManajemenKlaimController;
use App\Http\Controllers\Admin\PenyerahanController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\RiwayatPengelolaanController;

use App\Http\Controllers\Pelapor\LaporanKehilanganController;
use App\Http\Controllers\Pelapor\KlaimController;

use App\Http\Controllers\Satpam\BarangTemuanController;
use App\Http\Controllers\Satpam\RiwayatPenerimaanController;


/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])
    ->name('home');

Route::get('/cari-barang', [PublicController::class, 'index'])
    ->name('public.barang.index');

Route::get('/barang/{id}', [PublicController::class, 'show'])
    ->name('public.barang.show');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

Route::get('/verifikasi-email', [AuthController::class, 'showVerification'])
    ->name('verification.notice');

Route::post('/verifikasi-email', [AuthController::class, 'verifyEmail'])
    ->middleware('throttle:6,1')
    ->name('verification.verify');

Route::post('/verifikasi-email/kirim-ulang', [AuthController::class, 'resendVerification'])
    ->middleware('throttle:3,1')
    ->name('verification.resend');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])
    ->middleware('role:super_admin')
    ->name('dashboard.super-admin');

Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
    ->middleware('role:admin_kampus')
    ->name('dashboard.admin');

Route::get('/dashboard/satpam', [DashboardController::class, 'satpam'])
    ->middleware('role:satpam')
    ->name('dashboard.satpam');

Route::get('/dashboard/pelapor', [DashboardController::class, 'pelapor'])
    ->middleware('role:pelapor')
    ->name('dashboard.pelapor');


/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['role:super_admin'])
    ->prefix('super-admin')
    ->name('super-admin.')
    ->group(function () {

        Route::get(
            'kampus/{kampus}/detail',
            [App\Http\Controllers\SuperAdmin\DetailKampusController::class, 'show']
        )->name('kampus.detail');

        Route::resource('kampus', KampusController::class)
            ->except(['show']);

        Route::resource('admin-kampus', AdminKampusController::class)
            ->parameters([
                'admin-kampus' => 'adminKampus',
            ])
            ->except(['show']);

        Route::get(
            'riwayat-aktivitas',
            [RiwayatAktivitasController::class, 'index']
        )->name('riwayat-aktivitas.index');

    });


/*
|--------------------------------------------------------------------------
| Admin Kampus
|--------------------------------------------------------------------------
*/

Route::middleware(['role:admin_kampus'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Manajemen Satpam
        Route::resource('satpam', SatpamController::class)
            ->except(['show']);

        // Validasi Barang
        Route::get(
            'validasi-barang',
            [ValidasiBarangController::class, 'index']
        )->name('validasi-barang.index');

        Route::get(
            'validasi-barang/{id}',
            [ValidasiBarangController::class, 'show']
        )->name('validasi-barang.show');

        Route::post(
            'validasi-barang/{id}/mulai-pemeriksaan',
            [ValidasiBarangController::class, 'mulaiPemeriksaan']
        )->name('validasi-barang.mulai-pemeriksaan');

        Route::post(
            'validasi-barang/{id}/siap-publikasi',
            [ValidasiBarangController::class, 'siapDipublikasikan']
        )->name('validasi-barang.siap-publikasi');

        Route::post(
            'validasi-barang/{id}/siap-dipublikasikan',
            [ValidasiBarangController::class, 'siapDipublikasikan']
        )->name('validasi-barang.siap-dipublikasikan');

        Route::post(
            'validasi-barang/{id}/publikasikan',
            [ValidasiBarangController::class, 'publikasikan']
        )->name('validasi-barang.publikasikan');

        Route::post(
            'validasi-barang/{id}/tolak',
            [ValidasiBarangController::class, 'tolak']
        )->name('validasi-barang.tolak');

        // Barang Diterima Langsung
        Route::resource('barang-diterima', BarangDiterimaController::class)
            ->parameters([
                'barang-diterima' => 'id',
            ])
            ->except(['show']);

        Route::delete('barang-diterima/{id}/foto/{foto}', [BarangDiterimaController::class, 'hapusFoto'])->name('barang-diterima.foto.hapus');
        Route::post('barang-diterima/{id}/foto/{foto}/utama', [BarangDiterimaController::class, 'fotoUtama'])->name('barang-diterima.foto.utama');

        // Kelola Laporan Kehilangan
        Route::get(
            'laporan-kehilangan',
            [LaporanAdminController::class, 'index']
        )->name('laporan-kehilangan.index');

        Route::get(
            'laporan-kehilangan/{id}',
            [LaporanAdminController::class, 'show']
        )->name('laporan-kehilangan.show');

        Route::get(
            'laporan-kehilangan/{id}/foto/{foto}',
            [LaporanAdminController::class, 'lihatFoto']
        )->name('laporan-kehilangan.foto');

        Route::put(
            'laporan-kehilangan/{id}',
            [LaporanAdminController::class, 'update']
        )->name('laporan-kehilangan.update');

        // Verifikasi Klaim
        Route::get(
            'manajemen-klaim',
            [ManajemenKlaimController::class, 'index']
        )->name('manajemen-klaim.index');

        Route::get(
            'manajemen-klaim/{id}',
            [ManajemenKlaimController::class, 'show']
        )->name('manajemen-klaim.show');

        Route::post(
            'manajemen-klaim/{id}/setujui',
            [ManajemenKlaimController::class, 'setujui']
        )->name('manajemen-klaim.setujui');

        Route::post(
            'manajemen-klaim/{id}/minta-bukti',
            [ManajemenKlaimController::class, 'mintaBukti']
        )->name('manajemen-klaim.minta-bukti');

        Route::get(
            'manajemen-klaim/{id}/bukti',
            [ManajemenKlaimController::class, 'unduhBukti']
        )->name('manajemen-klaim.bukti');

        Route::post(
            'manajemen-klaim/{id}/tolak',
            [ManajemenKlaimController::class, 'tolak']
        )->name('manajemen-klaim.tolak');

        // W-15: Penyerahan Barang
        Route::get(
            'penyerahan',
            [PenyerahanController::class, 'index']
        )->name('penyerahan.index');

        Route::get(
            'penyerahan/riwayat',
            [PenyerahanController::class, 'riwayat']
        )->name('penyerahan.riwayat');

        Route::get(
            'penyerahan/{id}',
            [PenyerahanController::class, 'show']
        )->name('penyerahan.show');

        Route::post(
            'penyerahan/{id}',
            [PenyerahanController::class, 'store']
        )->name('penyerahan.store');

        // W-16: Riwayat Pengelolaan
        Route::get(
            'riwayat-pengelolaan',
            [RiwayatPengelolaanController::class, 'index']
        )->name('riwayat-pengelolaan.index');

    });


/*
|--------------------------------------------------------------------------
| Pelapor
|--------------------------------------------------------------------------
*/

Route::middleware(['role:pelapor'])
    ->prefix('pelapor')
    ->name('pelapor.')
    ->group(function () {

        Route::resource(
            'laporan-kehilangan',
            LaporanKehilanganController::class
        )
            ->parameters([
                'laporan-kehilangan' => 'laporan',
            ])
            ->except(['show']);

        Route::get(
            'laporan-kehilangan/{id}/foto/{foto}',
            [LaporanKehilanganController::class, 'lihatFoto']
        )->name('laporan-kehilangan.foto');

        Route::delete(
            'laporan-kehilangan/{id}/foto/{foto}',
            [LaporanKehilanganController::class, 'hapusFoto']
        )->name('laporan-kehilangan.foto.hapus');

        Route::get(
            'barang-tersedia',
            [KlaimController::class, 'index']
        )->name('klaim.index');

        Route::get(
            'barang-tersedia/{id}',
            [KlaimController::class, 'show']
        )->name('klaim.show');

        Route::post(
            'riwayat-klaim/{id}/bukti',
            [KlaimController::class, 'uploadBukti']
        )->name('klaim.upload-bukti');

        Route::post(
            'barang-tersedia/{id}/klaim',
            [KlaimController::class, 'store']
        )->name('klaim.store');

        Route::get(
            'riwayat-klaim',
            [KlaimController::class, 'riwayat']
        )->name('klaim.riwayat');

        Route::get(
            'riwayat-klaim/{id}',
            [KlaimController::class, 'detailRiwayat']
        )->whereNumber('id')->name('klaim.detail');

    });


/*
|--------------------------------------------------------------------------
| Satpam
|--------------------------------------------------------------------------
*/

Route::middleware(['role:satpam'])
    ->prefix('satpam')
    ->name('satpam.')
    ->group(function () {

        Route::resource('barang-temuan', BarangTemuanController::class)
            ->parameters([
                'barang-temuan' => 'barangTemuan',
            ])
            ->except(['show']);

        Route::delete('barang-temuan/{id}/foto/{foto}', [BarangTemuanController::class, 'hapusFoto'])->name('barang-temuan.foto.hapus');
        Route::post('barang-temuan/{id}/foto/{foto}/utama', [BarangTemuanController::class, 'fotoUtama'])->name('barang-temuan.foto.utama');

        Route::get(
            'riwayat-penerimaan',
            [RiwayatPenerimaanController::class, 'index']
        )->name('riwayat-penerimaan.index');

        Route::get(
            'riwayat-penerimaan/{id}',
            [RiwayatPenerimaanController::class, 'show']
        )->name('riwayat-penerimaan.show');

    });
