# ANAIR Web - Sistem Informasi Manajemen Produksi & Gudang

Sistem informasi berbasis web untuk pengelolaan administrasi produksi, gudang (stok), dan transaksi keluar barang di PT. ADITYA TIRTA ABADI UTAMA. Dibuat menggunakan Framework Laravel.

## Fitur Utama

-   **Manajemen User & Role:**
    -   Superadmin (Akses penuh ke manajemen user)
    -   Admin (Akses kelola data master, produksi, stok, dan transaksi)
    -   Karyawan (Akses view/input terbatas)
-   **Master Data:** Pengelolaan data produk (barang).
-   **Laporan Produksi:** Pencatatan hasil produksi harian, target, hasil, reject, dan nomor batch.
-   **Stok Barang:** Manajemen stok masuk manual dan otomatis dari hasil produksi.
-   **Transaksi Barang Keluar:** Pencatatan barang keluar (Surat Jalan/BBK) yang otomatis memotong stok.
-   **Cetak Laporan:** Fitur preview dan cetak surat jalan serta laporan produksi.

## Persyaratan Sistem (Localhost)

Sebelum menjalankan aplikasi, pastikan komputer Anda sudah terinstall:

1.  **PHP** (Minimal versi 8.0 atau 8.2 direkomendasikan).
2.  **Composer** (Dependency manager PHP).
3.  **MySQL / MariaDB** (Database, bisa via XAMPP/Laragon).
4.  **Web Server** (Apache/Nginx, atau bisa pakai `php artisan serve`).

## Panduan Instalasi & Setup

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

### 1. Clone atau Download Project
Jika menggunakan git:
```bash
git clone https://github.com/username/anair_web.git
cd anair_web
```
Atau ekstrak file `.zip` project ke folder kerja Anda.

### 2. Install Dependensi
Jalankan perintah ini di terminal (pastikan berada di dalam folder project):
```bash
composer install
```

### 3. Konfigurasi Environment (.env)
Copy file `.env.example` dan ubah namanya menjadi `.env`:
```bash
cp .env.example .env
```
_(Atau copy-paste manual file `.env.example`, rename jadi `.env`)_

Buka file `.env` dengan text editor, lalu sesuaikan konfigurasi database:
```editor
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anair          <-- Sesuaikan nama db
DB_USERNAME=root           <-- Sesuaikan username db (default xampp: root)
DB_PASSWORD=               <-- Sesuaikan password db (default xampp: kosong)
```

### 4. Generate Key Aplikasi
Jalankan perintah berikut untuk membuat key enkripsi Laravel:
```bash
php artisan key:generate
```

### 5. Setup Database
Pastikan Anda sudah membuat database kosong bernama `anair` (atau sesuai yang di `.env`) di phpMyAdmin/SQL Client.

Lalu jalankan migrasi tabel dan seeder (data awal):
```bash
php artisan migrate:fresh --seed
```
_Perintah ini akan membuat semua tabel dan mengisi data user default._

### 6. Jalankan Aplikasi
Jalankan server lokal Laravel:
```bash
php artisan serve
```
Akses aplikasi di browser melalui alamat:
`http://127.0.0.1:8000`

---

## Akun Login Default

Gunakan akun berikut untuk masuk pertama kali:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Super Admin** | `superadmin` | `12345` |
| **Admin Gudang** | `admin` | `12345` |
| **Karyawan** | `karyawan` | `12345` |

_Catatan: Segera ganti password setelah login demi keamanan._

## Troubleshooting Umum

-   **Error "Vite manifest not found":**
    Jika tampilan berantakan atau ada error terkait aset, coba jalankan:
    ```bash
    npm install
    npm run build
    ```
    _(Memerlukan Node.js terinstall)_

-   **Error Database:**
    Pastikan database sudah dibuat dan konfigurasi `.env` sudah benar. Coba jalankan `php artisan config:clear` jika habis mengubah file `.env`.

-   **Gambar/File tidak muncul:**
    Jalankan perintah symlink storage:
    ```bash
    php artisan storage:link
    ```

---
**PT. ADITYA TIRTA ABADI UTAMA**
Internal System

### Kontak & Dukungan
Jika memiliki kendala atau pertanyaan teknis terkait aplikasi ini, silahkan hubungi saya melalui GitHub:
[https://github.com/RockieBoy/](https://github.com/RockieBoy/)
