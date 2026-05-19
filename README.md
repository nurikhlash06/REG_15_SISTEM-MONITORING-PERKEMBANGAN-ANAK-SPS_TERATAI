# SPS Teratai - Sistem Monitoring Perkembangan Anak

Sistem informasi berbasis web yang dirancang khusus untuk mempermudah guru dan orang tua dalam memantau tumbuh kembang anak secara profesional,dan modern.

## Fitur Utama

### 🎓 Untuk Guru
- **Dashboard**: Ringkasan statistik murid, rombongan belajar, dan catatan perkembangan.
- **Manajemen Murid**: Pengelolaan data murid lengkap dengan foto profil, data fisik (berat badan, tinggi badan, lingkar kepala).
- **Manajemen Kelas**: Pengelolaan rombongan belajar (rombel).
- **Perkembangan**: Input dan edit catatan perkembangan anak.
- **Capaian Perkembangan**: Lihat capaian perkembangan anak secara detail dengan perhitungan nilai otomatis.
- **Akun Orang Tua**: Kelola akses orang tua ke sistem.
- **Hapus Riwayat**: Menghapus riwayat perkembangan satu per satu atau satu bulan sekaligus.
- **Pagination**: Riwayat perkembangan yang panjang dibagi menjadi halaman.

### 👨‍👩‍👧 Untuk Orang Tua
- **Dashboard**: Profil anak dengan target pencapaian, grafik aktivitas belajar 6 bulan terakhir, target perkembangan sesuai usia, dan perhitungan nilai lengkap.
- **Perkembangan**: Lihat semua laporan perkembangan anak.

### 📊 Aspek Penilaian
1. **Agama & Moral** (Bobot: 21)
2. **Perkembangan Fisik** (Bobot: 6)
3. **Program Literasi & Sains** (Bobot: 70)

### 📋 Skala Penilaian
- **BM**: Belum Muncul (0%)
- **KM**: Kadang-kadang Muncul (25%)
- **SM**: Sering Muncul (75%)
- **K**: Konsisten (100%)

### 🎯 Target Perkembangan
- **Kelompok A**: Usia 2 - <4 tahun (Target: ≥75%)
- **Kelompok B**: Usia 4 - <5 tahun (Target: ≥85%)
- **Kelompok C**: Usia 5 - <6 tahun (Target: ≥95%)

## Teknologi yang Digunakan

- **PHP 8.2+** dengan **Laravel 12.x**
- **MySQL** untuk basis data
- **Bootstrap 5** & **Bootstrap Icons** untuk UI/UX
- **Chart.js** untuk grafik visualisasi
- **Vite** untuk manajemen aset frontend

## Instalasi

1. Clone repositori ini.
2. Jalankan `composer install` untuk menginstal dependensi PHP.
3. Salin `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan `php artisan key:generate`.
5. Jalankan `php artisan migrate --seed` untuk membuat tabel dan data awal.
6. Jalankan `php artisan storage:link` untuk akses foto murid.
7. Jalankan `npm install && npm run build` untuk build aset frontend.
8. Jalankan `php artisan serve` untuk menjalankan server lokal.
9. Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

## Lisensi

Project ini dikembangkan untuk tujuan pendidikan dan monitoring perkembangan anak.
