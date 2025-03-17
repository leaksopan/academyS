<?php
// Tampilkan header
echo "===========================================\n";
echo "AcademyS - Setup dan Instalasi\n";
echo "===========================================\n\n";

// Cek apakah file database_setup.sql ada
if (!file_exists('database_setup.sql')) {
    echo "Error: File database_setup.sql tidak ditemukan.\n";
    exit(1);
}

// Cek apakah file import_database.php ada
if (!file_exists('import_database.php')) {
    echo "Error: File import_database.php tidak ditemukan.\n";
    exit(1);
}

// Tampilkan instruksi
echo "Langkah-langkah untuk menjalankan aplikasi:\n\n";
echo "1. Pastikan XAMPP sudah berjalan (Apache dan MySQL)\n";
echo "2. Buka browser dan akses URL berikut untuk mengimpor database:\n";
echo "   http://localhost/AcademyS/import_database.php\n\n";
echo "3. Setelah database berhasil diimpor, akses aplikasi di:\n";
echo "   http://localhost/AcademyS/\n\n";
echo "4. Gunakan kredensial berikut untuk login:\n";
echo "   - Admin: admin@academys.com / password\n";
echo "   - User: user1@example.com / password\n\n";
echo "===========================================\n";
echo "Terima kasih telah menggunakan AcademyS!\n";
echo "===========================================\n";
?> 