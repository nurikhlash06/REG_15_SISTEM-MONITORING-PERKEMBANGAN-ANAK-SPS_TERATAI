# DOKUMENTASI PROYEK - SPS TERATAI

## DESKRIPSI PROYEK

**SPS Teratai (Sistem Monitoring Perkembangan Anak)** adalah sistem informasi berbasis web yang dirancang khusus untuk mempermudah guru dan orang tua dalam memantau tumbuh kembang anak PAUD secara profesional, bersih, dan modern.

Sistem ini membantu guru dalam mencatat dan mengelola data perkembangan anak, serta memudahkan orang tua untuk melihat perkembangan anak mereka secara real-time dan terstruktur.

---

## SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

## Kebutuhan Fungsional Sistem

| SRS | DESKRIPSI |
|-----|-----------|
| **GURU** | |
| **1. Kelola Auth** | |
| SRS-F-001 | Sistem dapat melakukan proses login guru |
| SRS-F-002 | Sistem dapat menampilkan halaman dashboard guru |
| SRS-F-003 | Sistem dapat melakukan proses logout |
| **2. Kelola Murid** | |
| SRS-F-004 | Sistem dapat menambah data murid |
| SRS-F-005 | Sistem dapat mengedit data murid |
| SRS-F-006 | Sistem dapat menghapus data murid |
| SRS-F-007 | Sistem dapat menampilkan detail profil murid |
| **3. Kelola Kelas** | |
| SRS-F-008 | Sistem dapat menambah data kelas |
| SRS-F-009 | Sistem dapat mengedit data kelas |
| SRS-F-010 | Sistem dapat menghapus data kelas |
| **4. Kelola Perkembangan** | |
| SRS-F-011 | Sistem dapat menambah catatan perkembangan |
| SRS-F-012 | Sistem dapat mengedit catatan perkembangan |
| SRS-F-013 | Sistem dapat menghapus catatan perkembangan |
| **5. Kelola Capaian Perkembangan** | |
| SRS-F-014 | Sistem dapat menampilkan capaian perkembangan murid |
| SRS-F-015 | Sistem dapat menghapus riwayat perkembangan satu per satu |
| SRS-F-016 | Sistem dapat menghapus riwayat perkembangan satu bulan sekaligus |
| SRS-F-017 | Sistem dapat menampilkan pagination riwayat perkembangan |
| **6. Kelola Akun Orang Tua** | |
| SRS-F-018 | Sistem dapat menambah akun orang tua |
| SRS-F-019 | Sistem dapat mengedit akun orang tua |
| SRS-F-020 | Sistem dapat menghapus akun orang tua |
| **ORANG TUA** | |
| **1. Kelola Auth** | |
| SRS-F-021 | Sistem dapat melakukan proses login orang tua |
| SRS-F-022 | Sistem dapat menampilkan halaman dashboard orang tua |
| SRS-F-023 | Sistem dapat melakukan proses logout |
| **2. Lihat Perkembangan** | |
| SRS-F-024 | Sistem dapat menampilkan profil anak di dashboard |
| SRS-F-025 | Sistem dapat menampilkan grafik aktivitas belajar 6 bulan terakhir |
| SRS-F-026 | Sistem dapat menampilkan target perkembangan sesuai usia |
| SRS-F-027 | Sistem dapat menampilkan perhitungan nilai perkembangan |
| SRS-F-028 | Sistem dapat menampilkan semua laporan perkembangan anak |
| SRS-F-029 | Sistem dapat menampilkan detail laporan perkembangan |

## Kebutuhan Non Fungsional

| SRS | DESKRIPSI |
|-----|-----------|
| SRS-NF-001 | Sistem dirancang menggunakan bahasa pemrograman PHP dan Framework Laravel 12.x |
| SRS-NF-002 | Sistem mampu memproses input dan menampilkan halaman dalam waktu ≤ 3 detik |
| SRS-NF-003 | Sistem berbasis web dan dapat diakses melalui browser modern (Chrome, Firefox, Safari, Edge) |
| SRS-NF-004 | Sistem website dapat berjalan pada perangkat desktop, laptop, dan smartphone |
| SRS-NF-005 | Sistem harus memiliki antarmuka sederhana yang mudah digunakan oleh guru dan orang tua |
| SRS-NF-006 | Sistem harus memiliki uptime minimal 99% selama jam operasional |
| SRS-NF-007 | Sistem harus menggunakan autentikasi login dengan password terenkripsi |
| SRS-NF-008 | Sistem harus responsive dan menyesuaikan tampilan sesuai ukuran layar perangkat |

---

## DESAIN SISTEM

### Arsitektur Teknologi
- **Backend**: PHP 8.2+ dengan Laravel 12.x
- **Frontend**: Bootstrap 5, Bootstrap Icons, Chart.js
- **Database**: MySQL
- **Server**: Apache/Nginx

### Struktur Database

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

### Aspek Penilaian
1. **Agama & Moral** (Bobot: 21)
2. **Perkembangan Fisik** (Bobot: 6)
3. **Program Literasi & Sains** (Bobot: 70)

### Skala Penilaian
| Kode | Keterangan | Persentase |
|------|------------|------------|
| BM | Belum Muncul | 0% |
| KM | Kadang-kadang Muncul | 25% |
| SM | Sering Muncul | 75% |
| K | Konsisten | 100% |

### Target Perkembangan
| Kelompok | Usia | Target |
|----------|------|--------|
| A | 2 - <4 tahun | ≥75% |
| B | 4 - <5 tahun | ≥85% |
| C | 5 - <6 tahun | ≥95% |

---

## INSTALASI DAN KONFIGURASI

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

## USE CASE DIAGRAM

### Deskripsi Use Case Diagram

Sistem SPS Teratai memiliki 2 aktor utama:

1. **Guru**
   - Login ke sistem
   - Melihat dashboard guru
   - Logout dari sistem
   - Menambah data murid
   - Mengedit data murid
   - Menghapus data murid
   - Melihat detail profil murid
   - Menambah data kelas
   - Mengedit data kelas
   - Menghapus data kelas
   - Menambah catatan perkembangan
   - Mengedit catatan perkembangan
   - Menghapus catatan perkembangan
   - Melihat capaian perkembangan murid
   - Menghapus riwayat perkembangan satu per satu
   - Menghapus riwayat perkembangan satu bulan sekaligus
   - Menambah akun orang tua
   - Mengedit akun orang tua
   - Menghapus akun orang tua

2. **Orang Tua**
   - Login ke sistem
   - Melihat dashboard orang tua
   - Logout dari sistem
   - Melihat profil anak di dashboard
   - Melihat grafik aktivitas belajar
   - Melihat target perkembangan
   - Melihat perhitungan nilai perkembangan
   - Melihat semua laporan perkembangan anak
   - Melihat detail laporan perkembangan

---

## SKENARIO USE CASE

### Untuk Aktor GURU

| No | Use Case | Skenario Normal |
|----|----------|-----------------|
| 1 | Login Guru | 1. Guru membuka halaman login <br> 2. Guru memasukkan email dan password <br> 3. Guru menekan tombol Login <br> 4. Sistem memverifikasi kredensial <br> 5. Sistem menampilkan dashboard guru |
| 2 | Melihat Dashboard Guru | 1. Guru berhasil login <br> 2. Sistem menampilkan dashboard guru dengan statistik murid, rombel, dan catatan perkembangan bulan ini <br> 3. Guru melihat aksi cepat untuk navigasi |
| 3 | Logout | 1. Guru menekan tombol Logout di sidebar <br> 2. Sistem mengakhiri sesi <br> 3. Sistem menampilkan halaman login |
| 4 | Menambah Data Murid | 1. Guru membuka menu Daftar Murid <br> 2. Guru menekan tombol Tambah Murid <br> 3. Guru mengisi formulir data murid (nama lengkap, tempat lahir, tanggal lahir, jenis kelamin, agama, nama orang tua, email orang tua, telepon orang tua, foto, berat badan, tinggi badan, lingkar kepala, kelas) <br> 4. Guru menekan tombol Simpan <br> 5. Sistem menyimpan data murid dan menampilkan pesan sukses |
| 5 | Mengedit Data Murid | 1. Guru membuka menu Daftar Murid <br> 2. Guru menekan tombol Edit pada data murid yang ingin diubah <br> 3. Guru mengubah data murid yang diperlukan <br> 4. Guru menekan tombol Simpan <br> 5. Sistem memperbarui data murid dan menampilkan pesan sukses |
| 6 | Menghapus Data Murid | 1. Guru membuka menu Daftar Murid <br> 2. Guru menekan tombol Hapus pada data murid yang ingin dihapus <br> 3. Sistem menampilkan konfirmasi penghapusan <br> 4. Guru menekan tombol Ya untuk mengkonfirmasi <br> 5. Sistem menghapus data murid dan menampilkan pesan sukses |
| 7 | Melihat Detail Profil Murid | 1. Guru membuka menu Daftar Murid <br> 2. Guru menekan tombol Detail pada data murid <br> 3. Sistem menampilkan profil murid secara lengkap termasuk riwayat perkembangan |
| 8 | Menambah Catatan Perkembangan | 1. Guru membuka menu Perkembangan <br> 2. Guru menekan tombol Tambah Perkembangan <br> 3. Guru memilih murid, aspek perkembangan, skor penilaian, dan mengisi catatan <br> 4. Guru menekan tombol Simpan <br> 5. Sistem menyimpan catatan perkembangan dan menampilkan pesan sukses |
| 9 | Melihat Capaian Perkembangan | 1. Guru membuka menu Capaian Perkembangan <br> 2. Sistem menampilkan daftar murid beserta capaian perkembangannya <br> 3. Guru menekan tombol Detail pada murid yang ingin dilihat <br> 4. Sistem menampilkan capaian perkembangan secara detail beserta riwayat per bulan |
| 10 | Menghapus Riwayat Perkembangan Satu Bulan | 1. Guru membuka halaman detail capaian perkembangan murid <br> 2. Guru menekan tombol Hapus pada riwayat perkembangan per bulan yang ingin dihapus <br> 3. Sistem menampilkan konfirmasi penghapusan <br> 4. Guru menekan tombol Ya untuk mengkonfirmasi <br> 5. Sistem menghapus seluruh riwayat perkembangan bulan tersebut dan menampilkan pesan sukses |

### Untuk Aktor ORANG TUA

| No | Use Case | Skenario Normal |
|----|----------|-----------------|
| 1 | Login Orang Tua | 1. Orang tua membuka halaman login <br> 2. Orang tua memasukkan email dan password <br> 3. Orang tua menekan tombol Login <br> 4. Sistem memverifikasi kredensial <br> 5. Sistem menampilkan dashboard orang tua |
| 2 | Melihat Dashboard Orang Tua | 1. Orang tua berhasil login <br> 2. Sistem menampilkan dashboard orang tua dengan profil anak, grafik aktivitas belajar, target perkembangan, dan perhitungan nilai <br> 3. Orang tua melihat informasi perkembangan anak |
| 3 | Logout | 1. Orang tua menekan tombol Logout di sidebar <br> 2. Sistem mengakhiri sesi <br> 3. Sistem menampilkan halaman login |
| 4 | Melihat Semua Laporan Perkembangan | 1. Orang tua membuka menu Perkembangan <br> 2. Sistem menampilkan semua laporan perkembangan anak <br> 3. Orang tua melihat laporan perkembangan |
| 5 | Melihat Detail Laporan Perkembangan | 1. Orang tua menekan tombol Detail pada laporan perkembangan <br> 2. Sistem menampilkan detail laporan perkembangan secara lengkap |

---

## LISENSI

Project ini dikembangkan untuk tujuan pendidikan dan monitoring perkembangan anak.
