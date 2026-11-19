<?php

namespace App\Http\Middleware;

use App\Models\RiwayatAktivitas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CatatAktivitas
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya mencatat request yang berhasil mengubah data.
        if (
            !in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])
            || $response->getStatusCode() >= 400
        ) {
            return $response;
        }

        $auth = $request->session()->get('auth');

        if (!$auth || empty($auth['id']) || empty($auth['role'])) {
            return $response;
        }

        // Menentukan kolom aktor berdasarkan role.
        $aktor = [
            'id_super_admin' => null,
            'id_admin' => null,
            'id_satpam' => null,
        ];

        switch ($auth['role']) {
            case 'super_admin':
                $aktor['id_super_admin'] = $auth['id'];
                break;

            case 'admin_kampus':
                $aktor['id_admin'] = $auth['id'];
                break;

            case 'satpam':
                $aktor['id_satpam'] = $auth['id'];
                break;

            default:
                // Aktivitas Pelapor tidak dimasukkan ke tabel ini
                // karena skema tabel tidak menyediakan id_pelapor.
                return $response;
        }

        $route = $request->route();
        $routeName = $route?->getName() ?? 'aktivitas-tidak-diketahui';
        $routeParts = explode('.', $routeName);

        $namaAksi = match ($request->method()) {
            'POST' => 'Menambahkan',
            'PUT', 'PATCH' => 'Mengubah',
            'DELETE' => 'Menghapus',
            default => 'Melakukan',
        };

        $aksiKhusus = [
            'validasi' => 'Memvalidasi',
            'setujui' => 'Menyetujui',
            'tolak' => 'Menolak',
            'store' => 'Menyimpan',
        ];

        $aksiRoute = end($routeParts);

        if (isset($aksiKhusus[$aksiRoute])) {
            $namaAksi = $aksiKhusus[$aksiRoute];
        }

        $namaModul = count($routeParts) >= 2
            ? $routeParts[count($routeParts) - 2]
            : $routeName;

        $namaModul = Str::headline(str_replace('-', ' ', $namaModul));

        $tindakan = $namaAksi . ' data ' . $namaModul;

        // Mengambil ID dari parameter route jika tersedia.
        $referensiId = null;

        foreach ($route?->parameters() ?? [] as $parameter) {
            if (is_numeric($parameter)) {
                $referensiId = (int) $parameter;
                break;
            }
        }

        // Jenis referensi diambil dari nama route.
        $referensiJenis = count($routeParts) >= 2
            ? Str::limit($routeParts[count($routeParts) - 2], 50, '')
            : null;

        try {
            RiwayatAktivitas::create(array_merge($aktor, [
                'tindakan' => Str::limit($tindakan, 160, ''),
                'waktu' => now(),
                'referensi_jenis' => $referensiJenis,
                'referensi_id' => $referensiId,
            ]));
        } catch (Throwable $e) {
            // Kegagalan pencatatan log tidak boleh menggagalkan
            // proses utama yang sudah berhasil.
            report($e);
        }

        return $response;
    }
}
