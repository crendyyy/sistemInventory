# 📦 Sistem Inventory

Sistem Inventory adalah aplikasi manajemen inventaris modern berbasis web yang dibangun menggunakan **Laravel 13** dan **Tailwind CSS**. Aplikasi ini dirancang untuk membantu bisnis dalam mengelola produk, pembelian, penjualan, pelanggan, supplier, dan transaksi kas secara efisien dengan antarmuka yang bersih dan interaktif.

---

## ✨ Fitur Utama

- **Dashboard Interaktif** — Ringkasan statistik bisnis secara *real-time*, dilengkapi daftar *Produk Stok Menipis*, *Tagihan (Piutang)*, dan *Barang Inden Belum Diterima*.
- **Tema UI Modern** — Antarmuka pengguna yang bersih dan modern (bernuansa *Navy & Blue*), dilengkapi dengan tombol **Dark Mode / Light Mode Switcher** di *topbar*.
- **Manajemen Produk** — CRUD produk lengkap dengan kategori dan pelacakan stok yang terintegrasi otomatis.
- **Fitur Barang Inden (Pre-Order)** — Mendukung pembelian sistem Inden, di mana penambahan stok ditangguhkan hingga barang dikonfirmasi sudah diterima secara fisik.
- **Transaksi Pembelian & Penjualan** — Pencatatan transaksi yang mendetail, mendukung status pembayaran dinamis (*Lunas, Down Payment, Belum Bayar*).
- **Buku Kas Terintegrasi** — Pencatatan arus kas otomatis dari transaksi maupun manual, dilengkapi dengan **User Tracking** (pelacakan siapa yang mencatat kas).
- **Manajemen Kontak** — Pengelolaan data *Supplier* dan *Customer*.
- **Autentikasi Terpadu** — Halaman *Login* & *Register* bergaya modern, serta manajemen profil pengguna.
- **Export Laporan** — Mendukung cetak laporan transaksi dan kas ke dalam format **PDF & Excel**.
- **Realistic Data Seeder** — Dilengkapi dengan *seeder* canggih untuk menghasilkan puluhan data uji coba yang logis (skenario lunas/DP/ngutang, kas manual, dan variasi stok).

---

## 🔑 Default Login (Akses Admin)

Jika Anda melakukan *import database* dari file `.sql` bawaan atau menggunakan *seeder*, Anda dapat masuk ke dalam sistem menggunakan kredensial berikut:

- **Email:** `admin@rpc.com`
- **Password:** `password`

---

## 🛠️ Tech Stack

| Layer       | Teknologi                          |
| ----------- | ---------------------------------- |
| **Backend** | PHP 8.3+, Laravel 13               |
| **Frontend**| Blade, Tailwind CSS 3, Alpine.js   |
| **Build**   | Vite 8                             |
| **Database**| MySQL                              |
| **Auth**    | Laravel Breeze                     |
| **Export**  | DomPDF, Maatwebsite Excel          |

---

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL
- **Laragon** (Sangat Direkomendasikan untuk pengguna Windows) / XAMPP

---

## 🚀 Instalasi (Laragon Workflow)

Karena project ini dirancang agar mudah digunakan dengan **Laragon** di Windows, berikut adalah panduan instalasi tercepatnya:

### 1. Pindahkan Project ke Laragon
*Clone* atau letakkan folder `sistemInventory` ke dalam direktori `www` Laragon Anda:
```bash
C:\laragon\www\sistemInventory
```

### 2. Install Dependencies
Buka terminal/CMD di dalam folder project, lalu jalankan perintah berikut untuk mengunduh semua *library* PHP dan Node.js:
```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment
Gandakan file konfigurasi dan buat *application key*:
```bash
cp .env.example .env
php artisan key:generate
```
Pastikan file `.env` Anda memiliki konfigurasi database seperti berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbinventory
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database (Import SQL)
Untuk mendapatkan sistem yang sudah siap pakai beserta datanya:
1. Buka **Laragon** dan pastikan **Apache** (dengan SSL) dan **MySQL** sudah berjalan (klik *Start All*).
2. Klik tombol **Database** di Laragon untuk membuka *HeidiSQL* (atau *phpMyAdmin*).
3. Buat database baru bernama **`dbinventory`**.
4. **Import file `.sql`** yang telah disediakan ke dalam database tersebut. *(Catatan: Jika Anda ingin database kosong dari nol, lewati langkah import ini dan jalankan perintah `php artisan migrate` di terminal).*

### 5. Akses Aplikasi
Karena Anda menggunakan Laragon dengan fitur *Auto Virtual Hosts*, Anda **tidak perlu** repot-repot menjalankan `php artisan serve`.
Cukup buka browser Anda dan kunjungi:

👉 **[https://sisteminventory.test/](https://sisteminventory.test/)**

*(Gunakan awalan `https://` jika fitur SSL Laragon Anda menyala, atau `http://` jika SSL belum diaktifkan).*

---

## 🗄️ Struktur Database Induk

Aplikasi ini memiliki relasi database yang saling terhubung:

```text
users               (Manajemen Akun & Tracking)
├── cash_transactions (Buku Kas & Riwayat Keuangan)
│
categories          (Kategori Barang)
├── products        (Katalog Barang & Stok)
    ├── purchase_items (Detail Barang Masuk)
    └── sale_items     (Detail Barang Keluar)
│
suppliers           (Pemasok Barang)
├── purchases       (Transaksi Pembelian & Inden)
│
customers           (Pelanggan)
├── sales           (Transaksi Penjualan)
```

---

## 🧪 Testing

Untuk menjalankan pengujian (jika tersedia):
```bash
php artisan test
```

---

## 📝 Lisensi & Author

Project ini dibuat untuk keperluan manajemen inventaris yang modern dan efisien.

**Author:** crendyyy — [GitHub Profile](https://github.com/crendyyy)
