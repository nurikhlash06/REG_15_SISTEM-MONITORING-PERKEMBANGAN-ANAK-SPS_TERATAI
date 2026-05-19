<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Perkembangan;
use App\Traits\HasAspekStyles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    use HasAspekStyles;

    public function index()
    {
        $user = Auth::user();

        $totalAnak = 0;
        if (Schema::hasTable('murid') && Schema::hasColumn('murid', 'id_user_orangtua')) {
            $totalAnak = (int) DB::table('murid')->where('id_user_orangtua', $user->id)->count();
        }

        $anak = $this->anakCards($user->id);
        $chartPerBulan = $this->perkembanganBulananChart($user->id);

        foreach ($anak as $a) {
            $aspekResult = $this->aspekStatsPerAnak($a->id);
            $a->aspek_stats = $aspekResult['stats'];
            $a->total_persentase = $aspekResult['total_persentase'];
            $a->hitung = $aspekResult['hitung'];
            $a->bagian_penilaian = $aspekResult['bagian_penilaian'];
            $a->kode_penilaian = $aspekResult['kode_penilaian'];
            
            $narasi = $this->getNarasiOtomatis($a->tingkat ?? 'A');
            $a->target_perkembangan = $narasi;
        }

        $dynamicStyles = '';

        $dailyTip = $this->getDailyTip();

        $totalBobot = $this->getTotalBobot();
        
        return view('orangtua.dashboard', [
            'user' => $user,
            'stats' => [
                'total_anak' => $totalAnak,
            ],
            'anak' => $anak,
            'chartPerBulan' => $chartPerBulan,
            'dailyTip' => $dailyTip,
            'dynamicStyles' => $dynamicStyles,
            'totalBobot' => $totalBobot,
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

        $index = (int) date('z') % count($tips);
        return $tips[$index];
    }

    private function aspekStatsPerAnak(int $muridId): array
    {
        if (!Schema::hasTable('murid') || !Schema::hasTable('perkembangan')) {
            return ['stats' => [], 'total_persentase' => 0, 'hitung' => null, 'bagian_penilaian' => [], 'kode_penilaian' => []];
        }

        $murid = Murid::with('kelas')->find($muridId);
        if (!$murid) return ['stats' => [], 'total_persentase' => 0, 'hitung' => null, 'bagian_penilaian' => [], 'kode_penilaian' => []];

        $bagianPenilaian = $this->getBagianPenilaian();
        $kodePenilaian = $this->getKodePenilaian();

        $perkembanganList = Perkembangan::where('murid_id', $muridId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->latest('tanggal')
            ->get();

        $latestPerAspek = [];
        foreach ($perkembanganList as $p) {
            if (!isset($latestPerAspek[$p->aspek]) || $p->tanggal > $latestPerAspek[$p->aspek]->tanggal) {
                $latestPerAspek[$p->aspek] = $p;
            }
        }

        $hitung = $this->hitungPerkembangan($latestPerAspek);

        $stats = [];
        foreach ($bagianPenilaian as $nama => $config) {
            $nilaiBagian = $hitung['nilai_bagian'][$nama] ?? null;
            $persentase = $nilaiBagian ? $nilaiBagian['persentase_kode'] : 0;
            $statusLabel = $nilaiBagian && isset($kodePenilaian[$nilaiBagian['kode']]) ? $kodePenilaian[$nilaiBagian['kode']]['full'] : 'Belum ada data';
            $statusColor = $nilaiBagian && isset($kodePenilaian[$nilaiBagian['kode']]) ? $kodePenilaian[$nilaiBagian['kode']]['color'] : '#9ca3af';

            $stats[] = (object) [
                'name' => $nama,
                'count' => $perkembanganList->where('aspek', $nama)->count(),
                'percent' => $persentase,
                'status' => $statusLabel,
                'status_color' => $statusColor,
                'status_bg' => $statusColor . '20',
                'styles' => [
                    'icon' => $config['icon'],
                    'text' => $config['color'],
                ],
            ];
        }

        return [
            'stats' => $stats,
            'total_persentase' => $hitung['total_persentase'],
            'hitung' => $hitung,
            'bagian_penilaian' => $bagianPenilaian,
            'kode_penilaian' => $kodePenilaian,
        ];
    }

    private function anakCards(int $userId)
    {
        if (!Schema::hasTable('murid')) {
            return collect();
        }

        $anak = DB::table('murid')
            ->leftJoin('perkembangan', function ($join) {
                $join->on('perkembangan.murid_id', '=', 'murid.id')
                    ->whereMonth('perkembangan.tanggal', now()->month)
                    ->whereYear('perkembangan.tanggal', now()->year);
            })
            ->leftJoin('kelas', 'murid.kelas_id', '=', 'kelas.id')
            ->where('murid.id_user_orangtua', $userId)
            ->select(
                'murid.id',
                'murid.nama_lengkap',
                'murid.foto',
                'murid.nama_orang_tua',
                'murid.email_orang_tua',
                'murid.berat_badan',
                'murid.tinggi_badan',
                'murid.lingkar_kepala',
                'kelas.nama_kelas',
                'kelas.kode_kelas',
                'kelas.tingkat',
                DB::raw('count(perkembangan.id) as total_perkembangan')
            )
            ->groupBy('murid.id', 'murid.nama_lengkap', 'murid.foto', 'murid.nama_orang_tua', 'murid.email_orang_tua', 'murid.berat_badan', 'murid.tinggi_badan', 'murid.lingkar_kepala', 'kelas.nama_kelas', 'kelas.kode_kelas', 'kelas.tingkat')
            ->orderBy('murid.nama_lengkap')
            ->get();

        foreach ($anak as $a) {
            $bestAspek = DB::table('perkembangan')
                ->where('murid_id', $a->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->first();
            
            $a->best_aspek = $bestAspek ? $bestAspek->aspek : null;
            $a->best_skor = $bestAspek ? $bestAspek->skor : null;

            $kelompokUsia = $this->getKelompokUsia();
            $warnaHex = [
                'merah' => '#ef4444',
                'kuning' => '#f59e0b',
                'hijau' => '#10b981',
            ];
            $target = $kelompokUsia[$a->tingkat]['target'] ?? 75;
            $a->standar_nilai = [
                'kelompok' => $kelompokUsia[$a->tingkat]['label'] ?? $a->tingkat,
                'target' => $target,
                'status_warna' => $warnaHex,
            ];
        }

        return $anak;
    }

    private function perkembanganBulananChart(int $userId): array
    {
        if (!Schema::hasTable('murid') || !Schema::hasTable('perkembangan')) {
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
            $labels[] = $date->translatedFormat('M');
            $data[] = $rows->where('bulan', $monthKey)->first()->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
