# 📦 Sistem Inventory

Sistem Inventory adalah aplikasi manajemen inventaris berbasis web yang dibangun menggunakan **Laravel 13**. Aplikasi ini dirancang untuk membantu bisnis dalam mengelola produk, pembelian, penjualan, pelanggan, supplier, dan transaksi kas secara efisien.

---

## ✨ Fitur Utama

- **Dashboard** — Ringkasan statistik bisnis secara real-time (total produk, penjualan, pembelian, dll.)
- **Manajemen Produk** — CRUD produk lengkap dengan kategori dan tracking stok
- **Manajemen Kategori** — Pengelompokan produk berdasarkan kategori
- **Manajemen Supplier** — Pencatatan data supplier untuk pembelian barang
- **Manajemen Pelanggan** — Pencatatan data pelanggan untuk penjualan
- **Transaksi Pembelian** — Pencatatan pembelian barang dari supplier dengan detail item
- **Transaksi Penjualan** — Pencatatan penjualan barang ke pelanggan dengan detail item
- **Transaksi Kas** — Pencatatan arus kas masuk dan keluar
- **Autentikasi** — Login, register, dan manajemen profil pengguna
- **Export PDF** — Generate laporan dalam format PDF
- **Export Excel** — Generate laporan dalam format Excel

---

## 🛠️ Tech Stack

| Layer       | Teknologi                          |
| ----------- | ---------------------------------- |
| Backend     | PHP 8.3+, Laravel 13               |
| Frontend    | Blade, Tailwind CSS 3, Alpine.js   |
| Build Tool  | Vite 8                             |
| Database    | MySQL                              |
| Auth        | Laravel Breeze                     |
| PDF Export  | DomPDF (barryvdh/laravel-dompdf)   |
| Excel Export| Maatwebsite Excel                  |

---

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL
- Laragon / XAMPP / environment server lokal lainnya

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/crendyyy/sistemInventory.git
cd sistemInventory
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_inventory
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database

```bash
php artisan migrate
```

### 5. Build Frontend Assets

```bash
npm run build
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Atau gunakan script dev untuk menjalankan semua service sekaligus:

```bash
composer dev
```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

## 🗄️ Struktur Database

```
users
categories
suppliers
customers
products
purchases
├── purchase_items
sales
├── sale_items
cash_transactions
```

---

## 📁 Struktur Direktori Utama

```
sistemInventory/
├── app/
│   ├── Http/Controllers/      # Controller untuk setiap modul
│   └── Models/                # Eloquent Models
├── database/
│   └── migrations/            # Migrasi database
├── resources/
│   └── views/                 # Blade Templates
│       ├── auth/              # Halaman autentikasi
│       ├── categories/        # CRUD Kategori
│       ├── customers/         # CRUD Pelanggan
│       ├── products/          # CRUD Produk
│       ├── purchases/         # CRUD Pembelian
│       ├── sales/             # CRUD Penjualan
│       ├── cash_transactions/ # CRUD Transaksi Kas
│       ├── suppliers/         # CRUD Supplier
│       └── dashboard.blade.php
├── routes/
│   ├── web.php                # Route utama
│   └── auth.php               # Route autentikasi
└── ...
```

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📝 Lisensi

Project ini dibuat untuk keperluan pembelajaran dan pengembangan.

---

## 👤 Author

**crendyyy** — [GitHub](https://github.com/crendyyy)
