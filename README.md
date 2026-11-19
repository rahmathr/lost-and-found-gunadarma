# Lost & Found Gunadarma

Aplikasi berbasis web untuk membantu pengelolaan barang hilang dan barang temuan di lingkungan Universitas Gunadarma.

Lost & Found Gunadarma menyediakan sistem terpusat untuk pencatatan barang temuan, pelaporan kehilangan, validasi, pengajuan klaim, hingga proses penyerahan barang kepada pemiliknya.

## Fitur Utama

### 1. Super Admin
- Dashboard lintas kampus.
- Mengelola data kampus.
- Mengelola akun Admin Kampus.
- Melihat riwayat aktivitas sistem.

### 2. Admin Kampus
- Dashboard pengelolaan kampus.
- Mengelola akun Satpam.
- Memeriksa dan memvalidasi barang temuan.
- Mengelola laporan kehilangan.
- Mengelola pengajuan klaim.
- Mengelola proses penyerahan barang.
- Melihat riwayat pengelolaan.

### 3. Satpam
- Mencatat barang temuan.
- Mengelola data barang temuan.
- Melihat riwayat penerimaan barang.

### 4. Pelapor
- Melihat informasi barang temuan.
- Membuat laporan kehilangan.
- Mengajukan klaim barang.
- Memantau status laporan dan klaim.
- Melihat riwayat klaim.

## Teknologi

| Teknologi | Keterangan |
|---|---|
| PHP | 8.3 atau lebih baru |
| Laravel | 13 |
| Database | SQLite atau MySQL |
| Frontend | Blade, HTML, CSS, JavaScript |
| CSS Framework | Tailwind CSS 4 |
| Build Tool | Vite 8 |
| Package Manager PHP | Composer |
| Package Manager JavaScript | npm |

## Persyaratan Instalasi

Pastikan perangkat sudah memiliki:

- PHP 8.3 atau lebih baru.
- Composer 2.
- Node.js dan npm.
- Database SQLite atau MySQL.
- Git.

## Instalasi

### 1. Clone repository

```bash
git clone URL_REPOSITORY
```

Masuk ke folder proyek:

```bash
cd lost-and-found-gunadarma
```

### 2. Instal dependensi PHP

```bash
composer install
```

### 3. Buat file environment

```bash
cp .env.example .env
```

Untuk Windows PowerShell, jika perintah `cp` tidak tersedia:

```powershell
Copy-Item .env.example .env
```

### 4. Buat application key

```bash
php artisan key:generate
```

### 5. Konfigurasi database

Buka file `.env`.

**Pilihan A: SQLite**

```env
DB_CONNECTION=sqlite
```

Pastikan file database tersedia:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

**Pilihan B: MySQL**

Sesuaikan konfigurasi berikut dengan database lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lost_and_found_gunadarma
DB_USERNAME=root
DB_PASSWORD=
```

Buat database MySQL terlebih dahulu sebelum menjalankan migration.

### 6. Jalankan migration

```bash
php artisan migrate
```

### 7. Konfigurasi akun demo (opsional)

Untuk membuat akun awal melalui seeder, tambahkan password demo pada `.env`:

```env
DEMO_ACCOUNT_PASSWORD=
```

Isi dengan password lokal yang kuat. Jangan memasukkan password asli ke repository.

Jalankan:

```bash
php artisan db:seed
```

Seeder akun menggunakan `firstOrCreate()`. Akun yang sudah ada tidak akan diperbarui atau ditimpa password-nya.

### 8. Instal dependensi frontend

```bash
npm install
```

### 9. Build asset frontend

```bash
npm run build
```

### 10. Jalankan aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Konfigurasi Email

Aplikasi menggunakan konfigurasi mail Laravel melalui file `.env`.

Untuk pengiriman email menggunakan SMTP, sesuaikan konfigurasi berikut dengan penyedia layanan email yang digunakan:

```env
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Jangan publikasikan kredensial email atau password SMTP ke repository.

## Pengujian

Untuk menjalankan pengujian aplikasi:

```bash
php artisan test
```

Untuk memeriksa daftar route:

```bash
php artisan route:list
```

## Keamanan

- Jangan mengunggah file `.env`.
- Jangan mengunggah backup database atau data pengguna.
- Jangan memasukkan password, API key, maupun kredensial pribadi ke source code.
- Gunakan password yang kuat.
- Jangan menggunakan akun demo untuk lingkungan produksi.

## Struktur Role

Aplikasi memiliki empat jenis pengguna dengan hak akses berbeda:

- Super Admin
- Admin Kampus
- Satpam
- Pelapor

Setiap role memiliki akses sesuai tanggung jawabnya dalam proses pengelolaan barang hilang dan temuan.

## Pengembang

**Lost & Found Gunadarma**

Proyek pengembangan aplikasi web untuk pengelolaan barang hilang dan barang temuan di lingkungan Universitas Gunadarma.

---

*Dikembangkan menggunakan Laravel.*
