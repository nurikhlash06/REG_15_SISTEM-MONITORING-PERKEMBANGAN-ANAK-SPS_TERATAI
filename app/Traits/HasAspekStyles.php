<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasAspekStyles
{
    /**
     * Mendapatkan daftar bagian penilaian beserta bobotnya.
     */
    protected function getBagianPenilaian(): array
    {
        return [
            'Agama & Moral' => [
                'bobot' => 20,
                'icon' => 'bi-star-fill',
                'color' => '#f59e0b',
            ],
            'Perkembangan Fisik' => [
                'bobot' => 10,
                'icon' => 'bi-heart-pulse',
                'color' => '#10b981',
            ],
            'Program Literasi & Sains' => [
                'bobot' => 70,
                'icon' => 'bi-journal-text',
                'color' => '#6366f1',
            ],
        ];
    }

    /**
     * Mendapatkan total bobot semua bagian.
     */
    protected function getTotalBobot(): int
    {
        return array_sum(array_column($this->getBagianPenilaian(), 'bobot'));
    }

    /**
     * Mendapatkan kode penilaian beserta persentase dan labelnya.
     */
    protected function getKodePenilaian(): array
    {
        return [
            'BM' => ['short' => 'BM', 'full' => 'Belum Muncul', 'label' => 'Belum Muncul', 'persentase' => 0, 'color' => '#dc2626'],
            'KM' => ['short' => 'KM', 'full' => 'Kadang-kadang Muncul', 'label' => 'Kadang-kadang Muncul', 'persentase' => 25, 'color' => '#f97316'],
            'SM' => ['short' => 'SM', 'full' => 'Sering Muncul', 'label' => 'Sering Muncul', 'persentase' => 75, 'color' => '#22c55e'],
            'K' => ['short' => 'K', 'full' => 'Konsisten', 'label' => 'Konsisten', 'persentase' => 100, 'color' => '#8b5cf6'],
        ];
    }

    /**
     * Mendapatkan target perkembangan berdasarkan kelompok usia.
     */
    protected function getNarasiOtomatis(string $tingkat): array
    {
        $target = [
            'A' => [
                'judul' => 'Kelompok A (Usia 2 - <4 tahun)',
                'bagian' => [
                    [
                        'nama' => 'Agama & Moral',
                        'bobot' => 20,
                        'warna' => '#f59e0b',
                        'icon' => 'bi-star-fill',
                        'list' => [
                            'Mulai meniru gerakan ibadah / berdoa sesuai agamanya',
                            'Menyebut nama Tuhan dan ciptaan-Nya',
                            'Mengucapkan kata sopan dasar: salam, maaf, tolong, terima kasih',
                            'Meniru perilaku sopan dan lemah lembut',
                            'Mulai mengerti aturan sederhana (misal: tidak memukul, antre)',
                            'Menyayangi teman, hewan, dan tumbuhan',
                        ],
                    ],
                    [
                        'nama' => 'Perkembangan Fisik',
                        'bobot' => 10,
                        'warna' => '#10b981',
                        'icon' => 'bi-heart-pulse',
                        'list' => [
                            'Berjalan, berlari, melompat dengan seimbang',
                            'Memegang, menumpuk, dan memindahkan benda',
                            'Makan, minum, dan cuci tangan sedikit demi sedikit sendiri',
                            'Meniru gerakan tangan/jari (menggambar coretan, meremas, merobek)',
                            'Mengenal nama anggota tubuh dan gunanya',
                            'Menjaga kebersihan diri sederhana',
                        ],
                    ],
                    [
                        'nama' => 'Program Literasi & Sains',
                        'bobot' => 70,
                        'warna' => '#6366f1',
                        'icon' => 'bi-journal-text',
                        'list' => [
                            'Menyebutkan nama sendiri dan nama teman',
                            'Mengenal warna, bentuk, ukuran (besar - kecil)',
                            'Meniru bunyi, gerakan, dan nyanyian',
                            'Mengerti perintah 1-2 langkah: "Ambil bola", "Duduk", "Sini"',
                            'Mau berbagi mainan dengan teman',
                            'Mengelompokkan benda yang warnanya/bentuknya sama',
                            'Mulai percaya diri dekat orang lain',
                        ],
                    ],
                ],
            ],
            'B' => [
                'judul' => 'Kelompok B (Usia 4 - <5 tahun)',
                'bagian' => [
                    [
                        'nama' => 'Agama & Moral',
                        'bobot' => 20,
                        'warna' => '#f59e0b',
                        'icon' => 'bi-star-fill',
                        'list' => [
                            'Melakukan ibadah / berdoa dengan benar dan tertib, tidak cuma meniru',
                            'Menghormati orang tua, guru, dan orang yang lebih tua',
                            'Berperilaku jujur, sopan, dan baik hati setiap hari',
                            'Menolong teman yang susah, berbagi makanan/mainan',
                            'Menyadari bahwa semua makhluk adalah ciptaan Tuhan',
                            'Menjaga kebersihan sebagai bentuk ibadah',
                        ],
                    ],
                    [
                        'nama' => 'Perkembangan Fisik',
                        'bobot' => 10,
                        'warna' => '#10b981',
                        'icon' => 'bi-heart-pulse',
                        'list' => [
                            'Bergerak luwes: melompat, memanjat, menyeimbangkan badan dengan baik',
                            'Keterampilan jari halus: menggunting, menempel, menggambar garis & lingkaran',
                            'Berpakaian, buang air, dan bersih diri sudah bisa sendiri',
                            'Mengenal makanan sehat dan tidak sehat',
                            'Menjaga keselamatan diri: tidak lari di jalan, hati-hati benda tajam',
                        ],
                    ],
                    [
                        'nama' => 'Program Literasi & Sains',
                        'bobot' => 70,
                        'warna' => '#6366f1',
                        'icon' => 'bi-journal-text',
                        'list' => [
                            'Mengenal perasaan diri: senang, sedih, marah, dan mulai bisa mengendalikan emosi',
                            'Berani bicara dan menceritakan pengalaman sederhana di depan teman',
                            'Mengelompokkan & mengurutkan benda: ukuran, warna, jumlah',
                            'Mengenal huruf, angka, dan lambang sederhana',
                            'Mengenal nama daerah sendiri dan keberagaman teman (beda suku/agama)',
                            'Berkreasi: menggambar, menyanyi, bergerak sesuai imajinasi',
                        ],
                    ],
                ],
            ],
            'C' => [
                'judul' => 'Kelompok C (Usia 5 - <6 tahun)',
                'bagian' => [
                    [
                        'nama' => 'Agama & Moral',
                        'bobot' => 20,
                        'warna' => '#f59e0b',
                        'icon' => 'bi-star-fill',
                        'list' => [
                            'Memahami makna ibadah dan melaksanakannya dengan sadar dan baik',
                            'Berakhlak mulia setiap saat: jujur, hormat, sopan, kasih sayang',
                            'Menghargai perbedaan agama, suku, dan adat istiadat',
                            'Menjaga kebersihan, kelestarian alam, dan menyayangi makhluk hidup',
                            'Bersyukur atas pemberian Tuhan, tidak boros, dan hemat',
                            'Mengerti aturan hidup bermasyarakat dan menaatinya',
                        ],
                    ],
                    [
                        'nama' => 'Perkembangan Fisik',
                        'bobot' => 10,
                        'warna' => '#10b981',
                        'icon' => 'bi-heart-pulse',
                        'list' => [
                            'Bergerak kuat, luwes, dan terampil dalam permainan fisik',
                            'Keterampilan halus: menulis, mewarnai, melipat, menempel dengan rapi',
                            'Mandiri 100% dalam kebutuhan diri sendiri: makan, mandi, pakai baju, rapikan barang',
                            'Memahami pola hidup sehat: tidur cukup, makan sehat, olahraga',
                            'Menjaga keamanan diri dan orang lain',
                        ],
                    ],
                    [
                        'nama' => 'Program Literasi & Sains',
                        'bobot' => 70,
                        'warna' => '#6366f1',
                        'icon' => 'bi-journal-text',
                        'list' => [
                            'Mandiri, percaya diri, berani mencoba hal baru dan bertanggung jawab',
                            'Berpikir logis: berhitung sederhana, memecahkan masalah, sebab-akibat',
                            'Membaca tulisan sederhana, menulis nama sendiri, bercerita lancar & runtut',
                            'Memahami keberagaman Indonesia dan cinta tanah air',
                            'Berkreasi seni dengan ide sendiri',
                            'Memahami aturan, disiplin, dan siap masuk jenjang pendidikan dasar (SD)',
                        ],
                    ],
                ],
            ],
        ];

        return $target[$tingkat] ?? $target['A'];
    }

    /**
     * Mendapatkan konfigurasi kelompok usia beserta targetnya.
     */
    protected function getKelompokUsia(): array
    {
        return [
            'A' => [
                'label' => 'Kelompok A',
                'usia' => '2 - <4 tahun',
                'target' => 75,
                'warna' => [
                    'merah' => '<60',
                    'kuning' => '60-74',
                    'hijau' => '≥75',
                ],
            ],
            'B' => [
                'label' => 'Kelompok B',
                'usia' => '4 - <5 tahun',
                'target' => 85,
                'warna' => [
                    'merah' => '<75',
                    'kuning' => '75-84',
                    'hijau' => '≥85',
                ],
            ],
            'C' => [
                'label' => 'Kelompok C',
                'usia' => '5 - <6 tahun',
                'target' => 95,
                'warna' => [
                    'merah' => '<85',
                    'kuning' => '85-94',
                    'hijau' => '≥95',
                ],
            ],
        ];
    }

    /**
     * Mendapatkan status warna berdasarkan kelompok usia dan total persentase.
     */
    protected function getStatusWarna(string $tingkat, float $totalPersentase): array
    {
        // Kondisi khusus untuk 100%
        if ($totalPersentase == 100) {
            return [
                'status' => 'emas',
                'color' => '#fbbf24',
                'bg_color' => '#fffbeb',
            ];
        }

        $kelompokUsia = $this->getKelompokUsia();
        $config = $kelompokUsia[$tingkat] ?? $kelompokUsia['A'];

        $status = 'merah';
        $color = '#ef4444';
        $bgColor = '#fef2f2';

        if ($tingkat === 'A') {
            if ($totalPersentase >= 75) {
                $status = 'hijau';
                $color = '#10b981';
                $bgColor = '#f0fdf4';
            } elseif ($totalPersentase >= 60) {
                $status = 'kuning';
                $color = '#f59e0b';
                $bgColor = '#fffbeb';
            }
        } elseif ($tingkat === 'B') {
            if ($totalPersentase >= 85) {
                $status = 'hijau';
                $color = '#10b981';
                $bgColor = '#f0fdf4';
            } elseif ($totalPersentase >= 75) {
                $status = 'kuning';
                $color = '#f59e0b';
                $bgColor = '#fffbeb';
            }
        } elseif ($tingkat === 'C') {
            if ($totalPersentase >= 95) {
                $status = 'hijau';
                $color = '#10b981';
                $bgColor = '#f0fdf4';
            } elseif ($totalPersentase >= 85) {
                $status = 'kuning';
                $color = '#f59e0b';
                $bgColor = '#fffbeb';
            }
        }

        return [
            'status' => $status,
            'color' => $color,
            'bg_color' => $bgColor,
        ];
    }

    /**
     * Menghitung nilai perkembangan berdasarkan data penilaian.
     */
    protected function hitungPerkembangan(array $latestPerAspek): array
    {
        $bagianPenilaian = $this->getBagianPenilaian();
        $kodePenilaian = $this->getKodePenilaian();
        $totalBobot = $this->getTotalBobot();

        $nilaiBagian = [];
        $totalNilai = 0;

        foreach ($bagianPenilaian as $bagian => $config) {
            if (isset($latestPerAspek[$bagian])) {
                $p = $latestPerAspek[$bagian];
                $kode = $p->skor;
                $persentaseKode = $kodePenilaian[$kode]['persentase'] ?? 0;
                $nilai = ($persentaseKode / 100) * $config['bobot'];
                $nilaiBagian[$bagian] = [
                    'nilai' => $nilai,
                    'kode' => $kode,
                    'persentase_kode' => $persentaseKode,
                    'catatan' => $p->catatan,
                    'tanggal' => $p->tanggal,
                ];
                $totalNilai += $nilai;
            } else {
                $nilaiBagian[$bagian] = [
                    'nilai' => 0,
                    'kode' => null,
                    'persentase_kode' => 0,
                    'catatan' => null,
                    'tanggal' => null,
                ];
            }
        }

        $totalPersentase = $totalBobot > 0 ? round(($totalNilai / $totalBobot) * 100, 2) : 0;

        return [
            'nilai_bagian' => $nilaiBagian,
            'total_nilai' => $totalNilai,
            'total_persentase' => $totalPersentase,
        ];
    }

    /**
     * Legacy method for backward compatibility.
     */
    protected function getColorMap(): array
    {
        $bagian = $this->getBagianPenilaian();
        $colorMap = [];

        foreach ($bagian as $nama => $config) {
            $colorMap[$nama] = [
                'bg' => 'secondary',
                'icon' => $config['icon'],
                'text' => $config['color'],
                'icon_bg' => $config['color'] . '20',
                'card_bg' => $config['color'] . '10',
            ];
        }

        return $colorMap;
    }

    /**
     * Legacy method for backward compatibility.
     */
    protected function getSkorLabels(): array
    {
        $kode = $this->getKodePenilaian();
        $labels = [];

        foreach ($kode as $key => $config) {
            $labels[$key] = [
                'short' => $key,
                'full' => $config['label'],
                'points' => $config['persentase'],
                'color' => $config['color'],
            ];
        }

        return $labels;
    }

    /**
     * Generate dynamic CSS styles based on aspek options.
     */
    protected function generateDynamicStyles(array $aspekOptions, string $prefix = ''): string
    {
        $styles = '';
        $colorMap = $this->getColorMap();

        foreach ($aspekOptions as $aspek) {
            $slug = \Illuminate\Support\Str::slug($aspek);
            $config = $colorMap[$aspek] ?? [
                'card_bg' => '#f8fafc',
                'icon_bg' => '#f1f5f9',
                'text' => '#64748b'
            ];

            $styles .= ".aspek-card-{$slug} { background-color: {$config['card_bg']}; } ";
            $styles .= ".aspect-icon-{$slug} { background-color: {$config['icon_bg']}; color: {$config['text']}; } ";
        }

        return $styles;
    }
}
