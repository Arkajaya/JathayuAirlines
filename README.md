# JATHAYU Airlines V.1.0.0 — Web Aplikasi (UAS Pemrograman Web) 

Repositori ini berisi proyek web pemesanan maskapai untuk untuk memenuhi UAS matakuliah Pemrogaman Web 2025. README ini memuat cara setup lokal, dependensi utama, dan perintah troubleshooting cepat.

**Fitur Aplikasi**

**User**
- Registrasi Pengguna Baru
- Pemesanan Tiket Pesawat + Checkin Online
- Pengajuan Pembatalan (dengan dana refund)
- Pembayaran via Midtrans(sandbox)

**Admin dan Staff**
- Statistik Transaksi Pemesanan
- Manajemen User
- Manajemen Service (Pelayanan)
- Manajemen Cancellation (Approval Ajuan Pembatalan)
- Monitoring Transaksi, dan User Activity
Dan masing-masing role memiliki hak akses fitur yang berbeda

**Ringkasan teknologi**
- Laravel (Blade, Controllers, Middleware)
- Livewire (komponen interaktif)
- Filament (admin panel)
- Highcharts (widget admin, via CDN)
- Chart.js (infografis publik)
- Spatie Permission (opsional: role/permission)

## Prasyarat
- PHP >= 8.1
- Composer
- Node.js + npm (atau pnpm)
- PostgreSQL (default di .env, bisa ganti ke MySQL jika perlu)

## Install & Jalankan (singkat)
1. Install dependencies PHP

```bash
composer install
```

2. Install node deps (opsional untuk build aset)

```bash
npm install
# atau pnpm install
```

3. Copy `.env` dan sesuaikan (DB, APP_URL, MIDTRANS keys)

```bash
cp .env.example .env
# edit .env sesuai lingkungan
php artisan key:generate
```

4. Migrasi dan seed data (ada seeder contoh):

```bash
php artisan migrate --seed
# atau untuk development reset:
php artisan migrate:fresh --seed
```

5. Jalankan server lokal:

```bash
php artisan serve
```

6. (Opsional) Build aset produksi:

```bash
npm run build
```

## Perintah berguna
- Bersihkan cache/config/view/route dan autoload:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

## Admin / Filament
- Panel admin di `/admin`.
- Akun admin dibuat oleh seeder (cek `database/seeders/DatabaseSeeder.php`).
- Grafik di dashboard admin diinisialisasi oleh `public/js/filament-widgets-charts.js` dan Highcharts (CDN). Jika grafik kosong, periksa apakah file JS dan Highcharts dimuat di DevTools > Network.

## Dependensi library utama (ringkas)
- `laravel/framework` — core
- `filament/filament` — admin panel
- `livewire/livewire` — komponen interaktif
- `spatie/laravel-permission` — role/permission (jika dipakai)
- `midtrans/midtrans-php` — integrasi pembayaran (opsional)
- `chart.js` — infografis publik
Catatan: beberapa library di-load via CDN (Highcharts) dan beberapa via composer/npm.

## Perintah instalasi library (contoh)
Gunakan perintah di bawah ini untuk menambahkan dependensi utama. Sesuaikan sesuai kebutuhan proyek.

Composer (backend PHP):

```bash
composer require filament/filament
composer require livewire/livewire
composer require spatie/laravel-permission
composer require midtrans/midtrans-php
# Opsional (scaffolding auth):
composer require laravel/breeze --dev
```

Setelah `composer require`, jalankan migrasi dan publish config jika perlu:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --tag=filament-config
```

NPM (frontend / chart.js):

```bash
npm install chart.js
# atau jika pakai yarn/pnpm:
# yarn add chart.js
# pnpm add chart.js
```

Jika Anda ingin build aset:

```bash
npm run dev
# atau untuk produksi:
npm run build
```

Catatan: Filament biasanya diinstal via `composer require` dan memiliki instruksi setup tersendiri (tabel, publish, dan akun admin). Lihat dokumentasi masing-masing paket untuk langkah detail.

## Troubleshooting cepat
- Error: "Target class [App\\Http\\Middleware\\RedirectAdminToFilament] does not exist" → jalankan `composer dump-autoload` lalu `php artisan config:clear`.
- Grafik kosong → buka DevTools, periksa `filament-widgets-charts.js` dan `highcharts.js`; jalankan perintah cache clear jika ada perubahan file.

## Struktur penting
- `app/Filament` — resources & widgets Filament
- `app/Http` — controllers, middleware (mis. `RedirectAdminToFilament`)
- `public/js/filament-widgets-charts.js` — inisialisasi Highcharts
- `resources/views` — Blade views
- `database/seeders` — seeder data contoh


