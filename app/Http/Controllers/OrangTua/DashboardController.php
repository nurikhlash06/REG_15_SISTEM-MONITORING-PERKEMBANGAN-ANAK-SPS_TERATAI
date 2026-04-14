<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalAnak = 0;
        if (Schema::hasTable('murid') && Schema::hasColumn('murid', 'id_user_orangtua')) {
            $totalAnak = (int) DB::table('murid')->where('id_user_orangtua', $user->id)->count();
        }

        $anak = $this->anakCards($user->id);
        $chartPerBulan = $this->perkembanganBulananChart($user->id);
        $aspekStats = $this->aspekStats($user->id);
        
        // Fitur Tambahan: Tips Parenting Harian
        $dailyTip = $this->getDailyTip();

        return view('orangtua.dashboard', [
            'user' => $user,
            'stats' => [
                'total_anak' => $totalAnak,
            ],
            'anak' => $anak,
            'chartPerBulan' => $chartPerBulan,
            'aspekStats' => $aspekStats,
            'dailyTip' => $dailyTip,
        ]);
    }

    private function getDailyTip(): array
    {
        $tips = [
            [
                'title' => 'Membaca Buku',
                'content' => 'Membacakan buku sebelum tidur dapat meningkatkan kemampuan bahasa dan imajinasi anak.',
                'icon' => '📖'
            ],
            [
                'title' => 'Apresiasi Kecil',
                'content' => 'Berikan pujian yang spesifik saat anak melakukan hal baik, seperti "Hebat, kamu sudah merapikan mainan!".',
                'icon' => '🌟'
            ],
            [
                'title' => 'Waktu Istirahat',
                'content' => 'Tidur siang yang cukup membantu anak lebih fokus dan tidak mudah rewel di sore hari.',
                'icon' => '💤'
            ]
        ];

        // Pilih tip berdasarkan hari dalam setahun agar berganti setiap hari
        $index = (int) date('z') % count($tips);
        return $tips[$index];
    }

    private function aspekStats(int $userId): array
    {
        if (! Schema::hasTable('murid') || ! Schema::hasTable('perkembangan')) {
            return [];
        }

        $targetAspeks = [
            'Nilai Agama/Moral',
            'Fisik-Motorik',
            'Kognitif',
            'Bahasa',
            'Sosial-Emosional',
            'Seni'
        ];

        // Ambil rata-rata skor per aspek untuk seluruh anak orang tua ini
        // Kita hitung persentase: (rata-rata skor / 4) * 100
        $rows = DB::table('murid')
            ->join('perkembangan', 'perkembangan.murid_id', '=', 'murid.id')
            ->where('murid.id_user_orangtua', $userId)
            ->whereIn('perkembangan.aspek', $targetAspeks)
            ->where('perkembangan.tanggal', '>=', now()->startOfMonth()) // Hanya data bulan ini (Reset Bulanan)
            ->select(
                'perkembangan.aspek',
                DB::raw('count(perkembangan.id) as total'),
                DB::raw('avg(perkembangan.skor) as rata_skor')
            )
            ->groupBy('perkembangan.aspek')
            ->get()
            ->keyBy('aspek');

        $stats = [];
        foreach ($targetAspeks as $aspek) {
            $avg = $rows->has($aspek) ? (float) $rows[$aspek]->rata_skor : 0;
            $percent = $avg > 0 ? round(($avg / 4) * 100) : 0;

            // Pastikan minimal 1% jika sudah ada data
            if ($percent == 0 && ($rows->has($aspek) && $rows[$aspek]->total > 0)) {
                $percent = 1;
            }

            $stats[] = (object) [
                'name' => $aspek,
                'count' => $rows->has($aspek) ? $rows[$aspek]->total : 0,
                'percent' => $percent,
                'status' => $this->getStatusLabel($percent),
                'icon' => $this->getAspekIcon($aspek),
                'color' => $this->getAspekColor($aspek),
            ];
        }

        return $stats;
    }

    private function getStatusLabel(int $percent): string
    {
        if ($percent == 0) return 'Belum Ada';
        if ($percent < 50) return 'Perlu Perhatian';
        if ($percent <= 69) return 'Perlu Stimulasi';
        if ($percent <= 89) return 'Baik';
        return 'Sangat Baik';
    }

    private function getAspekIcon(string $aspek): string
    {
        return match ($aspek) {
            'Nilai Agama/Moral' => 'bi-moon-stars',
            'Fisik-Motorik' => 'bi-bicycle',
            'Kognitif' => 'bi-lightbulb',
            'Bahasa' => 'bi-chat-quote',
            'Sosial-Emosional' => 'bi-heart-pulse',
            'Seni' => 'bi-palette',
            default => 'bi-journal-text',
        };
    }

    private function getAspekColor(string $aspek): string
    {
        return match ($aspek) {
            'Nilai Agama/Moral' => 'blue',
            'Fisik-Motorik' => 'green',
            'Kognitif' => 'yellow',
            'Bahasa' => 'pink',
            'Sosial-Emosional' => 'red',
            'Seni' => 'purple',
            default => 'primary',
        };
    }

    private function anakCards(int $userId)
    {
        if (! Schema::hasTable('murid')) {
            return collect();
        }

        $anak = DB::table('murid')
            ->leftJoin('perkembangan', function ($join) {
                $join->on('perkembangan.murid_id', '=', 'murid.id')
                    ->whereMonth('perkembangan.tanggal', now()->month)
                    ->whereYear('perkembangan.tanggal', now()->year);
            })
            ->where('murid.id_user_orangtua', $userId)
            ->select(
                'murid.id',
                'murid.nama_lengkap',
                'murid.foto',
                'murid.nama_orang_tua',
                'murid.email_orang_tua',
                'murid.berat_badan',
                'murid.tinggi_badan',
                'murid.tinggi_lutut',
                DB::raw('count(perkembangan.id) as total_perkembangan')
            )
            ->groupBy('murid.id', 'murid.nama_lengkap', 'murid.foto', 'murid.nama_orang_tua', 'murid.email_orang_tua', 'murid.berat_badan', 'murid.tinggi_badan', 'murid.tinggi_lutut')
            ->orderBy('murid.nama_lengkap')
            ->get();

        // Cari capaian terbaik untuk masing-masing anak
        foreach ($anak as $a) {
            $bestAspek = DB::table('perkembangan')
                ->where('murid_id', $a->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->orderBy('skor', 'DESC')
                ->first();
            
            $a->best_aspek = $bestAspek ? $bestAspek->aspek : null;
            $a->best_skor = $bestAspek ? $bestAspek->skor : null;
        }

        return $anak;
    }

    /**
     * Grafik perkembangan per bulan (hingga 6 bulan ke belakang)
     * untuk seluruh anak yang dimiliki orang tua ini.
     */
    private function perkembanganBulananChart(int $userId): array
    {
        if (! Schema::hasTable('murid') || ! Schema::hasTable('perkembangan')) {
            return ['labels' => [], 'data' => []];
        }

        $rows = DB::table('murid')
            ->leftJoin('perkembangan', 'perkembangan.murid_id', '=', 'murid.id')
            ->where('murid.id_user_orangtua', $userId)
            ->whereNotNull('perkembangan.tanggal')
            ->where('perkembangan.tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(perkembangan.tanggal, '%Y-%m') as bulan"),
                DB::raw('count(perkembangan.id) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $labels[] = $date->translatedFormat('M'); // Contoh: Jan, Feb, Mar
            $data[] = $rows->where('bulan', $monthKey)->first()->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

