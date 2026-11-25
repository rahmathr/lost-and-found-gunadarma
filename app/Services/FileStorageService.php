<?php

namespace App\Services;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileStorageService
{
    /**
     * Memvalidasi jenis penyimpanan.
     */
    private function validateType(string $type): void
    {
        if (!in_array($type, ['public', 'private'], true)) {
            throw new \InvalidArgumentException(
                'Jenis penyimpanan harus public atau private.'
            );
        }
    }

    /**
     * Memastikan path relatif dan tidak mengandung traversal.
     */
    private function validatePath(string $path): string
    {
        $path = trim($path);

        if (
            $path === '' ||
            str_contains($path, "\0") ||
            str_contains($path, '\\') ||
            str_starts_with($path, '/') ||
            preg_match('/^[A-Za-z]:/', $path)
        ) {
            throw new \InvalidArgumentException(
                'Path file tidak valid.'
            );
        }

        $segments = explode('/', $path);

        foreach ($segments as $segment) {
            if (
                $segment === '' ||
                $segment === '.' ||
                $segment === '..'
            ) {
                throw new \InvalidArgumentException(
                    'Path file tidak valid.'
                );
            }
        }

        return $path;
    }

    /**
     * Memastikan direktori sesuai jenis penyimpanan.
     * Pemanggil tidak boleh menentukan prefix r2/ sendiri.
     */
    private function validateDirectory(
        string $directory,
        string $type
    ): string {
        $this->validateType($type);

        $directory = $this->validatePath($directory);

        if (Str::startsWith($directory, 'r2/')) {
            throw new \InvalidArgumentException(
                'Prefix R2 ditentukan otomatis oleh sistem.'
            );
        }

        $allowedDirectories = $type === 'public'
            ? ['foto-barang']
            : ['foto-laporan-kehilangan', 'bukti-klaim'];

        $validDirectory = false;

        foreach ($allowedDirectories as $allowed) {
            if (
                $directory === $allowed ||
                Str::startsWith($directory, $allowed . '/')
            ) {
                $validDirectory = true;
                break;
            }
        }

        if (!$validDirectory) {
            throw new \InvalidArgumentException(
                'Direktori tidak sesuai dengan jenis penyimpanan.'
            );
        }

        return $directory;
    }

    /**
     * Memvalidasi path berdasarkan kategori file.
     */
    private function validateStoragePath(
        string $path,
        string $type
    ): string {
        $this->validateType($type);

        $path = $this->validatePath($path);

        $relativePath = Str::startsWith($path, 'r2/')
            ? substr($path, 3)
            : $path;

        $allowedDirectories = $type === 'public'
            ? ['foto-barang']
            : ['foto-laporan-kehilangan', 'bukti-klaim'];

        $validPath = false;

        foreach ($allowedDirectories as $allowed) {
            if (Str::startsWith($relativePath, $allowed . '/')) {
                $validPath = true;
                break;
            }
        }

        if (!$validPath) {
            throw new \InvalidArgumentException(
                'Path file tidak sesuai dengan jenis penyimpanan.'
            );
        }

        return $path;
    }

    /**
     * Mengambil disk sesuai konfigurasi.
     */
    private function configuredDisk(string $type): string
    {
        $this->validateType($type);

        $disk = config("filesystems.uploads.{$type}");

        $allowed = $type === 'public'
            ? ['public', 'r2-public']
            : ['local', 'r2-private'];

        if (
            !is_string($disk) ||
            !in_array($disk, $allowed, true)
        ) {
            throw new \RuntimeException(
                'Konfigurasi disk penyimpanan tidak valid.'
            );
        }

        return $disk;
    }

    /**
     * Mengambil adapter filesystem Laravel.
     */
    private function storageDisk(string $disk): FilesystemAdapter
    {
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk($disk);

        return $storage;
    }

    /**
     * Menyimpan file sesuai konfigurasi disk.
     */
    public function store(
        UploadedFile $file,
        string $directory,
        string $type
    ): string|false {
        $directory = $this->validateDirectory($directory, $type);

        $disk = $this->configuredDisk($type);

        // Prefix R2 hanya ditambahkan secara internal.
        if (Str::startsWith($disk, 'r2-')) {
            $directory = 'r2/' . $directory;
        }

        return $file->store($directory, $disk);
    }

    /**
     * Menentukan disk berdasarkan lokasi file.
     */
    public function disk(string $path, string $type): string
    {
        $path = $this->validateStoragePath($path, $type);

        $isR2Path = Str::startsWith($path, 'r2/');

        if ($isR2Path) {
            return $type === 'public'
                ? 'r2-public'
                : 'r2-private';
        }

        return $type === 'public'
            ? 'public'
            : 'local';
    }

    /**
     * Memeriksa keberadaan file.
     */
    public function exists(string $path, string $type): bool
    {
        $disk = $this->disk($path, $type);

        return $this->storageDisk($disk)->exists($path);
    }

    /**
     * Menghapus file.
     */
    public function delete(string $path, string $type): bool
    {
        $disk = $this->disk($path, $type);

        return $this->storageDisk($disk)->delete($path);
    }

    /**
     * URL hanya tersedia untuk foto barang publik.
     */
    public function url(string $path): string
    {
        $path = $this->validateStoragePath($path, 'public');

        $disk = $this->disk($path, 'public');

        return $this->storageDisk($disk)->url($path);
    }

    /**
     * Menampilkan file privat.
     */
    public function response(
        string $path,
        string $type
    ): StreamedResponse {
        $this->validateType($type);

        if ($type !== 'private') {
            throw new \InvalidArgumentException(
                'Metode response hanya boleh digunakan untuk file privat.'
            );
        }

        $disk = $this->disk($path, 'private');

        return $this->storageDisk($disk)->response($path);
    }

    /**
     * Mengunduh file privat.
     */
    public function download(
        string $path,
        string $type
    ): StreamedResponse {
        $this->validateType($type);

        if ($type !== 'private') {
            throw new \InvalidArgumentException(
                'Metode download hanya boleh digunakan untuk file privat.'
            );
        }

        $disk = $this->disk($path, 'private');

        return $this->storageDisk($disk)->download($path);
    }

    /**
     * Membersihkan direktori lama dan prefix R2
     * untuk perintah reset aplikasi.
     */
    public function deleteDirectoryForReset(
        string $directory,
        string $type
    ): void {
        $this->validateType($type);

        $directory = $this->validatePath($directory);

        $allowedDirectories = $type === 'public'
            ? ['foto-barang']
            : ['foto-laporan-kehilangan', 'bukti-klaim'];

        if (!in_array($directory, $allowedDirectories, true)) {
            throw new \InvalidArgumentException(
                'Direktori reset tidak diizinkan.'
            );
        }

        // Bersihkan penyimpanan lokal lama.
        $legacyDisk = $type === 'public'
            ? 'public'
            : 'local';

        $this->storageDisk($legacyDisk)->deleteDirectory($directory);

        // Bersihkan direktori R2 jika konfigurasinya tersedia.
        $r2Disk = $type === 'public'
            ? 'r2-public'
            : 'r2-private';

        $r2Config = config("filesystems.disks.{$r2Disk}", []);

        if (
            !empty($r2Config['bucket']) &&
            !empty($r2Config['key']) &&
            !empty($r2Config['secret']) &&
            !empty($r2Config['endpoint'])
        ) {
            $this->storageDisk($r2Disk)->deleteDirectory(
                'r2/' . $directory
            );
        }
    }
}
