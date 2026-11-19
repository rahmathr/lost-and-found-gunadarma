<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ResetTotalAplikasi extends Command
{
    protected $signature = 'app:reset-total';

    protected $description = 'Reset seluruh database dan file unggahan aplikasi ke kondisi awal';

    public function handle(): int
    {
        if (app()->environment('production')) {
            $this->error('Reset diblokir: perintah ini tidak boleh dijalankan pada environment production.');
            return self::FAILURE;
        }

        $connection = (string) config('database.default');
        $database = (string) config("database.connections.{$connection}.database", '');
        $databaseLabel = $database !== '' ? $database : '(nama/path database tidak terdeteksi)';

        $this->newLine();
        $this->warn('PERINGATAN: RESET TOTAL APLIKASI');
        $this->line("Koneksi database : {$connection}");
        $this->line("Database         : {$databaseLabel}");
        $this->line('Semua tabel akan dihapus lalu dibuat ulang dari migration.');
        $this->line('Semua akun/data lama akan hilang, kemudian akun petugas default dibuat kembali.');
        $this->line('Folder foto barang, foto laporan kehilangan, dan bukti klaim akan dikosongkan.');
        $this->line('Folder unggahan lain dan file proyek lainnya tidak disentuh.');
        $this->newLine();

        if (! $this->confirm('Apakah backup database DAN folder storage sudah dibuat?', false)) {
            $this->info('Reset dibatalkan. Tidak ada data yang diubah.');
            return self::SUCCESS;
        }

        $typedDatabase = $this->ask('Ketik nama/path database persis seperti yang ditampilkan untuk melanjutkan');
        if (! is_string($typedDatabase) || $typedDatabase !== $databaseLabel) {
            $this->error('Nama database tidak cocok. Reset dibatalkan.');
            return self::FAILURE;
        }

        if (! $this->confirm('KONFIRMASI TERAKHIR: hapus seluruh data database dan file unggahan yang disebutkan?', false)) {
            $this->info('Reset dibatalkan. Tidak ada data yang diubah.');
            return self::SUCCESS;
        }

        $this->info('Menjalankan migration ulang dan seeder data awal...');

        try {
            $exitCode = Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);

            $output = trim(Artisan::output());
            if ($output !== '') {
                $this->line($output);
            }

            if ($exitCode !== 0) {
                $this->error('Migration/seeding gagal. Folder unggahan tidak dihapus. Periksa error di atas dan pulihkan dari backup bila diperlukan.');
                return self::FAILURE;
            }

            // Disk public berakar di storage/app/public.
            Storage::disk('public')->deleteDirectory('foto-barang');

            // Disk local pada konfigurasi proyek berakar di storage/app/private.
            Storage::disk('local')->deleteDirectory('foto-laporan-kehilangan');
            Storage::disk('local')->deleteDirectory('bukti-klaim');

            $this->newLine();
            $this->info('Reset selesai. Database sudah dibuat ulang dan folder unggahan terkait sudah dibersihkan.');
            $this->line('Akun default:');
            $this->line('- Super Admin: superadmin@gunadarma.ac.id');
            $this->line('- Admin Kampus: admin@gunadarma.ac.id');
            $this->line('- Satpam: satpam@gunadarma.ac.id');
            $this->line('Password ketiga akun: password123');
            $this->line('Akun Pelapor dan data transaksi contoh tidak dibuat.');

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Reset mengalami error: '.$exception->getMessage());
            $this->warn('Periksa kondisi database dan pulihkan dari backup jika diperlukan.');
            return self::FAILURE;
        }
    }
}
