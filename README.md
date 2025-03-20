# AcademyS - Platform Pembelajaran Online

AcademyS adalah platform pembelajaran online yang menyediakan berbagai kursus dengan materi interaktif, quiz, dan latihan coding. Platform ini dirancang untuk memudahkan proses belajar mengajar secara online dengan fitur-fitur yang komprehensif.

## Fitur Utama

### Untuk Pengguna
- **Katalog Kursus**: Jelajahi berbagai kursus yang tersedia dengan kategori yang berbeda
- **Materi Pembelajaran**: Akses materi pembelajaran dalam format teks dan multimedia
- **Quiz Interaktif**: Uji pemahaman dengan quiz interaktif dan dapatkan feedback langsung
- **Latihan Coding**: Praktikkan kemampuan coding dengan latihan langsung di browser
- **Progress Tracking**: Pantau kemajuan belajar dan capaian di setiap kursus
- **Diskusi**: Berpartisipasi dalam diskusi dengan instruktur dan sesama peserta

### Untuk Admin
- **Manajemen Kursus**: Tambah, edit, dan hapus kursus
- **Manajemen Materi**: Kelola materi pembelajaran dengan mudah
- **Manajemen Quiz**: Buat dan kelola quiz dengan berbagai jenis pertanyaan
- **Manajemen Latihan Coding**: Buat latihan coding dengan berbagai bahasa pemrograman
- **Manajemen Pengguna**: Kelola pengguna dan hak akses
- **Laporan dan Analitik**: Lihat laporan aktivitas dan performa pengguna

## Teknologi yang Digunakan

- **Backend**: PHP dengan framework CodeIgniter 3
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Editor Kode**: CodeMirror untuk latihan coding interaktif
- **Autentikasi**: Sistem login dan registrasi dengan verifikasi email

## Cara Instalasi

1. Clone repositori ini ke direktori web server Anda (misalnya: htdocs untuk XAMPP)
   ```
   git clone https://github.com/leaksopan/AcademyS.git
   ```

2. Import database dari file `database.sql` ke MySQL

3. Konfigurasi koneksi database di `application/config/database.php`

4. Konfigurasi base URL di `application/config/config.php`

5. Pastikan direktori `uploads` memiliki permission yang tepat (biasanya 755)

6. Akses aplikasi melalui browser: `http://localhost/AcademyS`

## Struktur Aplikasi

- **Admin Panel**: Akses melalui `http://localhost/AcademyS/admin`
- **User Dashboard**: Akses melalui `http://localhost/AcademyS/dashboard`
- **Katalog Kursus**: Akses melalui `http://localhost/AcademyS/courses`

## Fitur Quiz

Quiz di AcademyS memiliki beberapa fitur utama:

- **Multiple Choice**: Pertanyaan pilihan ganda dengan satu jawaban benar
- **Essay**: Pertanyaan essay untuk jawaban yang lebih mendalam
- **Nilai Otomatis**: Sistem penilaian otomatis untuk pertanyaan pilihan ganda
- **Riwayat Quiz**: Melihat riwayat percobaan quiz dan nilai tertinggi
- **Batas Nilai Kelulusan**: Setiap quiz memiliki batas nilai kelulusan yang dapat diatur

Setelah menyelesaikan quiz, pengguna akan tetap berada di halaman quiz dan dapat melihat:
- Nilai yang diperoleh pada percobaan tersebut
- Nilai tertinggi dari semua percobaan
- Status kelulusan (lulus/belum lulus)
- Riwayat semua percobaan quiz

## Fitur Latihan Coding

Latihan coding di AcademyS mendukung beberapa bahasa pemrograman:

- HTML
- CSS
- JavaScript
- PHP

Fitur latihan coding meliputi:
- Editor kode interaktif dengan syntax highlighting
- Preview hasil kode secara real-time
- Validasi kode otomatis
- Starter code dan solution code yang dapat diatur oleh admin

## Kontribusi

Jika Anda ingin berkontribusi pada pengembangan AcademyS, silakan fork repositori ini dan kirimkan pull request.

## Lisensi

AcademyS dilisensikan di bawah [MIT License](LICENSE).
