# DOKUMENTASI PROYEK - SPS TERATAI

## DESKRIPSI PROYEK

**SPS Teratai (Sistem Monitoring Perkembangan Anak)** adalah sistem informasi berbasis web yang dirancang khusus untuk mempermudah guru dan orang tua dalam memantau tumbuh kembang anak PAUD secara profesional, bersih, dan modern.

Sistem ini membantu guru dalam mencatat dan mengelola data perkembangan anak, serta memudahkan orang tua untuk melihat perkembangan anak mereka secara real-time dan terstruktur.

---

## SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

### 1. TUJUAN PROYEK
- Memudahkan guru dalam mencatat dan mengelola data perkembangan anak PAUD.
- Memberikan akses kepada orang tua untuk melihat perkembangan anak secara transparan.
- Menyediakan laporan perkembangan yang terstruktur dan mudah dipahami.

### 2. PENGGUNA SISTEM
1. **Guru**: Pengguna utama yang mengelola semua data dan mencatat perkembangan anak.
2. **Orang Tua**: Pengguna yang melihat laporan perkembangan anak mereka.

---

## 3. KEBUTUHAN FUNGSIONAL

### 3.1 Fitur untuk Guru

| No | Fitur | Deskripsi |
|----|-------|-----------|
| 1 | **Login & Logout** | Guru dapat login ke sistem dan logout dengan aman. |
| 2 | **Dashboard Guru** | Menampilkan ringkasan statistik total murid, total rombel, dan catatan perkembangan bulan ini. |
| 3 | **Manajemen Murid** | - Menambah, mengedit, dan menghapus data murid. <br> - Menyimpan foto profil murid. <br> - Menyimpan data fisik murid (berat badan, tinggi badan, lingkar kepala). <br> - Melihat detail profil murid. |
| 4 | **Manajemen Kelas** | - Menambah, mengedit, dan menghapus rombongan belajar (rombel). <br> - Menetapkan tingkat kelompok usia (A, B, C). |
| 5 | **Manajemen Perkembangan** | - Menambah, mengedit, dan menghapus catatan perkembangan anak. <br> - Memilih aspek perkembangan dan skor penilaian. <br> - Menyimpan catatan tambahan. |
| 6 | **Capaian Perkembangan** | - Melihat capaian perkembangan masing-masing anak secara detail. <br> - Melihat perhitungan nilai otomatis. <br> - Melihat riwayat perkembangan per bulan. <br> - Menghapus riwayat perkembangan satu per satu atau satu bulan sekaligus. <br> - Pagination untuk riwayat perkembangan yang panjang. |
| 7 | **Manajemen Akun Orang Tua** | - Menambah, mengedit, dan menghapus akun orang tua. <br> - Menghubungkan akun orang tua dengan data murid. |

### 3.2 Fitur untuk Orang Tua

| No | Fitur | Deskripsi |
|----|-------|-----------|
| 1 | **Login & Logout** | Orang tua dapat login ke sistem dan logout dengan aman. |
| 2 | **Dashboard Orang Tua** | - Menampilkan profil anak dengan target pencapaian. <br> - Menampilkan grafik aktivitas belajar 6 bulan terakhir. <br> - Menampilkan target perkembangan sesuai usia (accordion). <br> - Menampilkan perhitungan nilai lengkap. |
| 3 | **Lihat Perkembangan** | - Melihat semua laporan perkembangan anak. <br> - Melihat detail laporan perkembangan. |

---

## 4. KEBUTUHAN NON-FUNGSIONAL

### 4.1 Kinerja (Performance)
- Sistem harus dapat menampilkan halaman dalam waktu kurang dari 3 detik.
- Sistem harus menangani setidaknya 50 pengguna bersamaan tanpa penurunan kinerja yang signifikan.

### 4.2 Keandalan (Reliability)
- Sistem harus memiliki uptime minimal 99% selama jam operasional.
- Sistem harus dapat memulihkan data jika terjadi kesalahan.

### 4.3 Kegunaan (Usability)
- Antarmuka harus intuitif dan mudah dipahami oleh pengguna tanpa pelatihan khusus.
- Navigasi harus jelas dan mudah diakses dari setiap halaman.
- Warna dan layout harus konsisten di seluruh halaman.

### 4.4 Keamanan (Security)
- Sistem harus menggunakan autentikasi login dengan password terenkripsi.
- Hanya pengguna yang terotorisasi yang dapat mengakses fitur sesuai peran (guru/orang tua).
- Sistem harus melindungi data sensitif murid dan orang tua.

### 4.5 Portabilitas (Portability)
- Sistem harus dapat diakses melalui browser modern (Chrome, Firefox, Safari, Edge).
- Sistem harus responsive dan dapat diakses dari perangkat desktop, tablet, dan smartphone.

### 4.6 Maintainability
- Kode harus terstruktur dan mudah dipahami.
- Dokumentasi harus lengkap dan jelas.

---

## 5. DESAIN SISTEM

### 5.1 Arsitektur Teknologi
- **Backend**: PHP 8.2+ dengan Laravel 12.x
- **Frontend**: Bootstrap 5, Bootstrap Icons, Chart.js
- **Database**: MySQL
- **Server**: Apache/Nginx

### 5.2 Struktur Database

#### Tabel `users`
- Menyimpan data pengguna (guru dan orang tua)
- Kolom: id, name, email, password, role, created_at, updated_at

#### Tabel `kelas`
- Menyimpan data rombongan belajar
- Kolom: id, nama_kelas, kode_kelas, tingkat, created_at, updated_at

#### Tabel `murid`
- Menyimpan data murid
- Kolom: id, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, nama_orang_tua, email_orang_tua, telepon_orang_tua, foto, berat_badan, tinggi_badan, lingkar_kepala, kelas_id, id_user_orangtua, created_at, updated_at

#### Tabel `perkembangan`
- Menyimpan data perkembangan anak
- Kolom: id, murid_id, tanggal, aspek, skor, catatan, is_read, created_at, updated_at

### 5.3 Aspek Penilaian
1. **Agama & Moral** (Bobot: 21)
2. **Perkembangan Fisik** (Bobot: 6)
3. **Program Literasi & Sains** (Bobot: 70)

### 5.4 Skala Penilaian
| Kode | Keterangan | Persentase |
|------|------------|------------|
| BM | Belum Muncul | 0% |
| KM | Kadang-kadang Muncul | 25% |
| SM | Sering Muncul | 75% |
| K | Konsisten | 100% |

### 5.5 Target Perkembangan
| Kelompok | Usia | Target |
|----------|------|--------|
| A | 2 - <4 tahun | ≥75% |
| B | 4 - <5 tahun | ≥85% |
| C | 5 - <6 tahun | ≥95% |

---

## 6. INSTALASI DAN KONFIGURASI

1. Clone repositori ini.
2. Jalankan `composer install` untuk menginstal dependensi PHP.
3. Salin `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan `php artisan key:generate`.
5. Jalankan `php artisan migrate --seed` untuk membuat tabel dan data awal.
6. Jalankan `php artisan storage:link` untuk akses foto murid.
7. Jalankan `npm install && npm run build` untuk build aset frontend.
8. Jalankan `php artisan serve` untuk menjalankan server lokal.
9. Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## 7. LISENSI

Project ini dikembangkan untuk tujuan pendidikan dan monitoring perkembangan anak.
