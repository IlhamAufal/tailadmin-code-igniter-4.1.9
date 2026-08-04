# TailAdmin — CodeIgniter 4 Edition

> Template admin dashboard **TailAdmin Free** yang telah dimigrasikan ke **CodeIgniter 4.1.9**.  
> Dibangun dengan Tailwind CSS, Alpine.js, dan sistem layout native CI4 (Extend/Section/Include).

---

## 📋 Daftar Isi

- [Tech Stack](#-tech-stack)
- [Struktur Folder](#-struktur-folder)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Cara Menambah Halaman Baru](#-cara-menambah-halaman-baru)
- [Cara Menambah Route](#-cara-menambah-route)
- [Fitur Dashboard](#-fitur-dashboard)
- [Lisensi](#-lisensi)

---

## 🛠 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend Framework** | CodeIgniter 4.1.9 |
| **PHP** | 7.4+ / 8.0+ |
| **CSS Framework** | Tailwind CSS v4 (compiled → `public/assets/css/style.css`) |
| **Interaktivitas** | Alpine.js v3 (bundled → `public/assets/js/bundle.js`) |
| **Web Server** | Apache (XAMPP) atau `php spark serve` |
| **Package Manager** | Composer |

---

## 📁 Struktur Folder

```
tailadmin/
├── .env                          # Konfigurasi environment (tidak di-commit)
├── .gitignore
├── .htaccess                     # Redirect root → public/ (URL bersih)
├── app/
│   ├── Config/
│   │   ├── App.php               # baseURL, indexPage, dll
│   │   ├── Routes.php            # Definisi routing
│   │   ├── Autoload.php
│   │   └── Filters.php
│   ├── Controllers/
│   │   ├── BaseController.php    # Controller dasar (autoload helper url, form)
│   │   └── Dashboard.php         # Controller dashboard utama
│   └── Views/
│       ├── layouts/
│       │   └── main.php          # Layout master (HTML shell + Alpine x-data)
│       ├── partials/
│       │   ├── sidebar.php       # Sidebar navigasi
│       │   ├── navbar.php        # Topbar / header
│       │   ├── preloader.php     # Loading spinner
│       │   ├── overlay.php       # Overlay mobile sidebar
│       │   └── footer_scripts.php # Tag <script> bundle.js
│       └── dashboard/
│           └── index.php         # Halaman dashboard (extend layout master)
├── public/
│   ├── .htaccess                 # Rewrite rule CI4 standar
│   ├── index.php                 # Front controller (jangan diubah)
│   ├── favicon.ico
│   └── assets/
│       ├── css/
│       │   └── style.css         # Compiled Tailwind CSS
│       ├── js/
│       │   └── bundle.js         # Alpine.js + semua JS (compiled)
│       └── images/
│           ├── logo/             # logo.svg, logo-dark.svg, logo-icon.svg
│           ├── user/             # Avatar user
│           ├── product/          # Gambar produk
│           └── ...
├── composer.json
├── composer.lock
├── env                           # Template .env — salin ke .env saat setup
├── spark                         # CLI CodeIgniter
├── tests/
└── writable/                     # Cache, log, session (di-ignore git)
```

---

## ✅ Prasyarat

Pastikan sudah terinstal:

| Tools | Versi Minimum | Catatan |
|-------|---------------|---------|
| **PHP** | 7.4 | Rekomendasi: PHP 8.1 |
| **Composer** | 2.x | [getcomposer.org](https://getcomposer.org) |
| **Apache** | 2.4 | Via XAMPP, Laragon, atau native |
| **mod_rewrite** | — | Wajib aktif di Apache |
| **MySQL** | 5.7 / 8.0 | Opsional — hanya jika pakai database |

> **Catatan:** Node.js **tidak diperlukan** untuk menjalankan project ini.  
> CSS dan JS sudah dalam bentuk file compiled di `public/assets/`.

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/tailadmin.git
cd tailadmin
```

> **Pengguna Windows + XAMPP:** Taruh folder project di `C:\xampp\htdocs\tailadmin\`

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Salin File Environment

```bash
# Linux / macOS
cp env .env

# Windows (PowerShell)
Copy-Item env .env
```

### 4. Aktifkan mod_rewrite di XAMPP

Buka `C:\xampp\apache\conf\httpd.conf`, pastikan baris berikut **tidak** dikomentari:

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

Dan di bagian `<Directory "C:/xampp/htdocs">`:

```apache
AllowOverride All
```

Lalu restart Apache di XAMPP Control Panel.

---

## ⚙️ Konfigurasi

Edit file `.env` sesuai lingkungan lokal:

```ini
# Mode aplikasi (development / production / testing)
CI_ENVIRONMENT = development

# URL dasar aplikasi — sesuaikan dengan lokasi project
# Jika menggunakan XAMPP:
app.baseURL = 'http://localhost/tailadmin/'

# Jika menggunakan php spark serve:
# app.baseURL = 'http://localhost:8080/'

# Hilangkan index.php dari URL (wajib jika mod_rewrite aktif)
app.indexPage = ''
```

> **Penting:** Jangan commit file `.env` ke GitHub — sudah di-ignore di `.gitignore`.

### Konfigurasi Database (Opsional)

Jika project Anda memerlukan database, tambahkan di `.env`:

```ini
database.default.hostname = localhost
database.default.database = nama_database
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

---

## ▶️ Menjalankan Aplikasi

### Via XAMPP (Rekomendasi)

1. Pastikan **Apache** sudah berjalan di XAMPP Control Panel
2. Buka browser, akses:

```
http://localhost/tailadmin/
```

### Via PHP Built-in Server (`spark serve`)

```bash
php spark serve
```

Lalu akses:

```
http://localhost:8080/
```

> **Catatan `spark serve`:** Ubah `app.baseURL` di `.env` menjadi `http://localhost:8080/`

---

## 📄 Cara Menambah Halaman Baru

Contoh: menambahkan halaman **Profil**.

### 1. Buat View

Buat file `app/Views/profile/index.php`:

```php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        <?= esc($title) ?>
    </h1>
    <!-- Konten halaman di sini -->
</div>
<?= $this->endSection() ?>
```

### 2. Buat Controller

Buat file `app/Controllers/Profile.php`:

```php
<?php

namespace App\Controllers;

class Profile extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
        ];

        return view('profile/index', $data);
    }
}
```

### 3. Tambahkan Route

Edit `app/Config/Routes.php`:

```php
$routes->get('profile', 'Profile::index');
```

Akses di browser: `http://localhost/tailadmin/profile`

---

## 🔀 Cara Menambah Route

Edit file `app/Config/Routes.php`:

```php
// GET route sederhana
$routes->get('halaman', 'NamaController::namaMethod');

// Route dengan parameter
$routes->get('produk/(:num)', 'Produk::detail/$1');

// Group route (misal: admin panel)
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('users', 'Admin::users');
});

// Route untuk form (GET + POST)
$routes->get('kontak', 'Kontak::index');
$routes->post('kontak/kirim', 'Kontak::send');
```

---

## ✨ Fitur Dashboard

Halaman dashboard utama (`/`) menampilkan:

- **Metrik ringkasan** — Total customer, order, penjualan, dan pertumbuhan
- **Statistik eCommerce** — Visualisasi dengan chart ApexCharts
- **Tabel order terbaru** — Data tabular responsif
- **Sidebar navigasi** — Collapsible dengan dark mode support
- **Topbar / header** — Notifikasi, pencarian, profil pengguna
- **Dark mode** — Toggle via Alpine.js + localStorage
- **Preloader** — Animasi loading saat halaman pertama dibuka
- **Responsif** — Mobile-first layout dengan sidebar overlay

### Komponen Alpine.js yang Aktif

| Komponen | `x-data` Key | Deskripsi |
|----------|-------------|-----------|
| Dark Mode | `darkMode` | Toggle dark/light, disimpan di localStorage |
| Sidebar Toggle | `sidebarToggle` | Buka/tutup sidebar di mobile |
| Scroll Top | `scrollTop` | Deteksi scroll untuk sticky navbar |
| Menu Aktif | `selected` (di sidebar) | Highlight menu aktif via `$persist` |

---

## 🔒 Catatan Keamanan

- File `.env` **wajib** ada di `.gitignore` — berisi kredensial sensitif
- CSRF protection tersedia di `app/Config/Filters.php` — aktifkan untuk form POST:
  ```php
  'before' => ['csrf'],
  ```
- Selalu gunakan `esc()` saat menampilkan data dari user/database ke view
- Folder `app/` dilindungi oleh `.htaccess` (deny all direct access)

---

## 🛠 Perintah Spark yang Berguna

```bash
# Jalankan development server
php spark serve

# Buat controller baru
php spark make:controller NamaController

# Buat model baru
php spark make:model NamaModel

# Buat migration baru
php spark make:migration CreateNamaTable

# Jalankan migration
php spark migrate

# Cek list route yang terdaftar
php spark routes

# Clear cache
php spark cache:clear
```

---

## 📦 Dependensi

### PHP (Composer)

| Package | Versi |
|---------|-------|
| `codeigniter4/framework` | 4.1.9 |

### Aset Frontend (sudah compiled, tidak perlu npm)

| Library | Versi | Lokasi |
|---------|-------|--------|
| Tailwind CSS | v4 | `public/assets/css/style.css` |
| Alpine.js | v3.14.1 | `public/assets/js/bundle.js` |
| ApexCharts | v3.51.0 | `public/assets/js/bundle.js` |
| FullCalendar | v6.1.15 | `public/assets/js/bundle.js` |
| Flatpickr | v4.6.13 | `public/assets/js/bundle.js` |
| JSVectorMap | v1.6.0 | `public/assets/js/bundle.js` |
| Swiper | v11.1.14 | `public/assets/js/bundle.js` |
| Dropzone | v6.0.0 | `public/assets/js/bundle.js` |

---

## 📝 Lisensi

Project ini menggunakan lisensi **MIT**.  
Template TailAdmin original: [tailadmin.com](https://tailadmin.com) — dirilis di bawah lisensi MIT.  
Framework CodeIgniter 4: [codeigniter.com](https://codeigniter.com) — dirilis di bawah lisensi MIT.
