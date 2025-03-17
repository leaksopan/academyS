# AcademyS - Platform Pembelajaran Online

AcademyS adalah platform pembelajaran online yang memungkinkan pengguna untuk belajar pemrograman dan pengembangan web secara interaktif. Aplikasi ini dibangun menggunakan framework CodeIgniter.

## Fitur

- **Autentikasi Pengguna**: Registrasi, login, dan reset password
- **Katalog Kursus**: Daftar kursus yang tersedia dengan filter berdasarkan kategori dan level
- **Pembelajaran Interaktif**: Materi pembelajaran dengan editor kode interaktif
- **Pelacakan Progres**: Pelacakan kemajuan belajar pengguna
- **Dashboard Pengguna**: Tampilan kursus yang diikuti dan progres pembelajaran
- **Profil Pengguna**: Pengaturan profil dan preferensi pengguna
- **Panel Admin**: Pengelolaan kursus, pelajaran, kategori, dan pengguna

## Persyaratan Sistem

- PHP 7.3 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)
- XAMPP/WAMP/MAMP (untuk pengembangan lokal)

## Instalasi

1. Clone repositori ini ke direktori web server Anda:
   ```
   git clone https://github.com/username/academys.git
   ```

2. Pastikan XAMPP (Apache dan MySQL) sudah berjalan

3. Buka browser dan akses URL berikut untuk mengimpor database:
   ```
   http://localhost/AcademyS/import_database.php
   ```

4. Setelah database berhasil diimpor, akses aplikasi di:
   ```
   http://localhost/AcademyS/
   ```

## Kredensial Demo

Gunakan kredensial berikut untuk login:

- **Admin**:
  - Email: admin@academys.com
  - Password: password

- **User**:
  - Email: user1@example.com
  - Password: password

## Struktur Direktori

```
AcademyS/
├── application/          # Direktori aplikasi CodeIgniter
│   ├── config/           # File konfigurasi
│   ├── controllers/      # Controller
│   ├── models/           # Model
│   ├── views/            # View
│   └── ...
├── assets/               # Aset statis (CSS, JS, gambar)
│   ├── css/              # File CSS
│   ├── js/               # File JavaScript
│   └── images/           # Gambar
├── system/               # Core CodeIgniter
├── .htaccess             # Konfigurasi Apache
├── database_setup.sql    # File SQL untuk setup database
├── import_database.php   # Script untuk mengimpor database
└── index.php             # File utama
```

## Pengembangan

Untuk menjalankan aplikasi dalam mode pengembangan:

1. Pastikan XAMPP (Apache dan MySQL) sudah berjalan
2. Akses aplikasi di `http://localhost/AcademyS/`

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).