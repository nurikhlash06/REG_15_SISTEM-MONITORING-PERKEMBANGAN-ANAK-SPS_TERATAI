<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
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

        $totalMurid = $this->safeCount(['murid']);
        
        // Menghitung total kelas dari tabel kelas
        $totalKelas = Kelas::where('status', 'aktif')->count();

        $totalPerkembangan = 0;
        if (Schema::hasTable('perkembangan')) {
            $totalPerkembangan = DB::table('perkembangan')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();
        }

        // Data Tambahan Baru
        $greeting = $this->getGreeting();
        $recentActivities = $this->getRecentActivities();
        $progressBulanIni = $this->getProgressBulanIni($totalMurid);

        $chartAspek = $this->aspekCounts();
        $chartBulanan = $this->monthlyCounts();

        // Data statistik fisik murid (Rata-rata)
        $fisikStats = $this->getFisikStats();
        
        // Generate dynamic styles
        $aspekOptions = array_keys($this->getColorMap());
        $dynamicStyles = $this->generateDynamicStyles($aspekOptions, 'aspek');

        return view('guru.dashboard', [
            'user' => $user,
            'greeting' => $greeting,
            'stats' => [
                'total_murid' => $totalMurid,
                'total_kelas' => $totalKelas,
                'total_perkembangan' => $totalPerkembangan,
                'progress_bulan_ini' => $progressBulanIni,
                'fisik' => $fisikStats,
            ],
            'recentActivities' => $recentActivities,
            'chartAspek' => $chartAspek,
            'chartBulanan' => $chartBulanan,
            'dynamicStyles' => $dynamicStyles,
            'colorMap' => $this->getColorMap(),
        ]);
    }

    private function getFisikStats(): array
    {
        if (!Schema::hasTable('murid')) {
            return [
                'avg_bb' => 0, 'count_bb' => 0,
                'avg_tb' => 0, 'count_tb' => 0,
                'avg_lk' => 0, 'count_lk' => 0
            ];
        }

        return [
            'avg_bb' => round(DB::table('murid')->where('berat_badan', '>', 0)->avg('berat_badan') ?? 0, 1),
            'count_bb' => DB::table('murid')->where('berat_badan', '>', 0)->count(),
            
            'avg_tb' => round(DB::table('murid')->where('tinggi_badan', '>', 0)->avg('tinggi_badan') ?? 0, 1),
            'count_tb' => DB::table('murid')->where('tinggi_badan', '>', 0)->count(),
            
            'avg_lk' => round(DB::table('murid')->where('lingkar_kepala', '>', 0)->avg('lingkar_kepala') ?? 0, 1),
            'count_lk' => DB::table('murid')->where('lingkar_kepala', '>', 0)->count(),
        ];
    }

    private function getGreeting(): string
    {
        $hour = now()->hour;
        if ($hour < 11) return 'Selamat Pagi';
        if ($hour < 15) return 'Selamat Siang';
        if ($hour < 19) return 'Selamat Sore';
        return 'Selamat Malam';
    }

    private function getRecentActivities(): \Illuminate\Support\Collection
    {
        if (!Schema::hasTable('perkembangan')) return collect();

        return DB::table('perkembangan')
            ->join('murid', 'perkembangan.murid_id', '=', 'murid.id')
            ->select(
                'perkembangan.id',
                'perkembangan.aspek',
                'perkembangan.skor',
                'perkembangan.tanggal',
                'perkembangan.created_at',
                'murid.nama_lengkap as nama_murid',
                'murid.foto as foto_murid'
            )
            ->orderBy('perkembangan.created_at', 'DESC')
            ->limit(5)
            ->get();
    }

    private function getProgressBulanIni(int $totalMurid): array
    {
        if ($totalMurid === 0 || !Schema::hasTable('perkembangan')) {
            return ['count' => 0, 'percentage' => 0];
        }

        $muridSudahUpdate = DB::table('perkembangan')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->distinct('murid_id')
            ->count('murid_id');

        return [
            'count' => $muridSudahUpdate,
            'percentage' => round(($muridSudahUpdate / $totalMurid) * 100),
        ];
    }

    private function safeCount(array $candidateTables): int
    {
        foreach ($candidateTables as $table) {
            if (Schema::hasTable($table)) {
                return (int) DB::table($table)->count();
            }
        }

        return 0;
    }

    private function aspekCounts(): array
    {
        if (! Schema::hasTable('perkembangan')) {
            return ['labels' => [], 'data' => []];
        }

        $targetAspeks = array_keys($this->getColorMap());

        $rows = DB::table('perkembangan')
            ->select('aspek', DB::raw('count(*) as total'))
            ->whereIn('aspek', $targetAspeks)
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month) // Selalu filter berdasarkan bulan berjalan
            ->groupBy('aspek')
            ->get()
            ->keyBy('aspek');

        $labels = [];
        $data = [];

        foreach ($targetAspeks as $aspek) {
            $labels[] = $aspek;
            $data[] = $rows->has($aspek) ? $rows[$aspek]->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function monthlyCounts(): array
    {
        if (! Schema::hasTable('perkembangan')) {
            return ['labels' => [], 'data' => []];
        }

        $rows = DB::table('perkembangan')
            ->select(DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"), DB::raw('count(*) as total'))
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = $month;
            $data[] = $rows->where('bulan', $month)->first()->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

