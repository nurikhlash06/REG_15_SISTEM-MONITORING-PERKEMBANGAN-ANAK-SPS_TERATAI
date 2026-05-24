# SPS Teratai - Sistem Monitoring Perkembangan Anak

Sistem informasi berbasis web yang dirancang khusus untuk mempermudah guru dan orang tua dalam memantau tumbuh kembang anak secara profesional, dan modern.

## Fitur Utama

- **Dashboard Guru**: Ringkasan statistik murid, kelas, dan aktivitas terbaru.
- **Manajemen Murid & Kelas**: Pengelolaan data murid lengkap dengan foto profil dan riwayat fisik.
- **Monitoring Orang Tua**: Dashboard khusus wali murid untuk melihat progress 6 aspek perkembangan anak (Agama, Fisik-Motorik, Kognitif, Bahasa, Sosial-Emosional, Seni).
- **Visualisasi Dinamis**: Menggunakan sistem warna dan ikon minimalis yang memudahkan pemantauan.
- **Laporan Perkembangan**: Catatan historis perkembangan anak yang dapat dipantau dari waktu ke waktu.

## Teknologi yang Digunakan

- **PHP 8.4+** dengan **Laravel 12.x**
- **MySQL** untuk basis data
- **Bootstrap 5** & **Bootstrap Icons** untuk UI/UX
- **Vite** untuk manajemen aset frontend

## Instalasi

1. Clone repositori ini.
2. Jalankan `composer install` untuk menginstal dependensi PHP.
3. Salin `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan `php artisan key:generate`.
5. Jalankan `php artisan migrate --seed` untuk membuat tabel dan data awal.
6. Jalankan `php artisan storage:link` untuk akses foto murid.
7. Jalankan `npm install && npm run dev` untuk aset frontend.
8. Akses aplikasi melalui browser.

## Lisensi

Project ini dikembangkan untuk tujuan pendidikan dan monitoring perkembangan anak.
