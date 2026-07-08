# 🏨 Sistem Informasi Manajemen Nura Boutique Hotel

Sistem Informasi Manajemen Nura Boutique Hotel adalah aplikasi berbasis web yang dirancang untuk mendukung dan mengotomatisasi proses bisnis operasional hotel, mulai dari reservasi, check-in, check-out, hingga pembuatan laporan. Sistem ini dibangun menggunakan **Laravel Framework 12** dengan menerapkan pola arsitektur **MVC (Model-View-Controller)** agar mudah dikembangkan lebih lanjut.

---

## 📌 Deskripsi Proyek

Sistem ini dikembangkan sebagai pemenuhan tugas mata kuliah **Pemrograman Web II**, dengan tujuan menerapkan konsep pemrograman web modern menggunakan framework Laravel, termasuk relasi basis data, autentikasi berbasis role, otomasi proses bisnis, serta fitur ekspor laporan.

---

## ✨ Fitur Utama

### 🗄️ Struktur Database
Sistem mengimplementasikan **8 tabel database** dengan **5 jenis relasi**:
- **One-to-One**: `users` ↔ `user_profiles`
- **One-to-Many**:
  - `tipe_kamar` → `kamar`
  - `tamu` → `booking`
  - `kamar` → `booking`
- **Many-to-Many**: `tipe_kamar` ↔ `fasilitas`

### 🔐 Autentikasi & Manajemen Role
- Dua role pengguna: **Admin** dan **Petugas**
- Middleware custom untuk membatasi akses halaman
- Admin memiliki akses penuh ke seluruh sistem
- Petugas hanya dapat mengakses modul operasional

### 🏢 Proses Bisnis Inti
- **Reservasi** kamar
- **Check-in** tamu
- **Check-out** tamu
- Kalkulasi harga otomatis
- Update status kamar secara *real-time*
- Pencatatan petugas yang menangani setiap transaksi

### 📊 Laporan & Ekspor Data
- Ekspor laporan ke **Excel** menggunakan `Fast Excel`
- Ekspor laporan ke **PDF** menggunakan `DomPDF`

### 🌟 Fitur Tambahan
- **Log Activity** (audit trail)
- **Dark Mode**
- Nota **PDF check-out**
- Manajemen **profil pengguna**

---

## 🛠️ Teknologi yang Digunakan

| Kategori         | Teknologi              |
|-------------------|------------------------|
| Framework Backend | Laravel 12             |
| Bahasa Pemrograman| PHP                    |
| Database          | MySQL                  |
| Ekspor Excel      | Fast Excel             |
| Ekspor PDF        | DomPDF                 |
| Arsitektur        | MVC (Model-View-Controller) |

---

## 🚀 Instalasi & Menjalankan Proyek

```bash
# Clone repository
git clone https://github.com/username/nura-boutique-hotel.git

# Masuk ke direktori proyek
cd nura-boutique-hotel

# Install dependency PHP
composer install

# Install dependency JavaScript
npm install

# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Konfigurasi database pada file .env
# DB_DATABASE=nama_database
# DB_USERNAME=username
# DB_PASSWORD=password

# Jalankan migrasi database beserta seeder
php artisan migrate --seed

# Jalankan server lokal
php artisan serve
```

Setelah server berjalan, akses aplikasi melalui `http://127.0.0.1:8000`.

---

## 📁 Struktur Database Singkat

```
users ──1:1── user_profiles

tipe_kamar ──1:N── kamar
tamu ──1:N── booking
kamar ──1:N── booking

tipe_kamar ──N:N── fasilitas
```

---

## ✅ Kesimpulan

Sistem Informasi Manajemen Nura Boutique Hotel berhasil dibangun menggunakan Laravel Framework 12 dengan menerapkan pola arsitektur MVC yang terstruktur. Sistem berhasil mengimplementasikan delapan tabel database dengan lima jenis relasi, fitur autentikasi dua role menggunakan middleware custom, otomasi proses bisnis reservasi hingga check-out, ekspor laporan ke Excel dan PDF, serta fitur tambahan seperti Log Activity, Dark Mode, nota PDF check-out, dan manajemen profil pengguna guna meningkatkan fungsionalitas dan pengalaman pengguna sistem.

---

## 👩‍💻 Identitas Pengembang

| Data              | Keterangan                        |
|-------------------|------------------------------------|
| **Nama**          | Nur Anisa                         |
| **NPM**           | 23552011171                       |
| **Mata Kuliah**   | Pemrograman Web II                |
| **Dosen Pengampu**| Ipan Saepul Milal, S.Kom.          |
| **Kampus**        | Universitas Teknologi Bandung      |

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik pada mata kuliah Pemrograman Web II, Universitas Teknologi Bandung.
