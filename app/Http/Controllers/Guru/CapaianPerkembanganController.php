<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Perkembangan;
use App\Traits\HasAspekStyles;
use Illuminate\Http\Request;

class CapaianPerkembanganController extends Controller
{
    use HasAspekStyles;

    public function index(Request $request)
    {
        $query = Murid::query()->with('kelas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%");
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $muridList = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();
        $kelasList = \App\Models\Kelas::all();
        $colorMap = $this->getColorMap();
        $skorLabels = $this->getSkorLabels();

        $bulan = $request->filled('bulan') ? $request->integer('bulan') : now()->month;
        $tahun = $request->filled('tahun') ? $request->integer('tahun') : now()->year;

        $capaianPerMurid = [];
        foreach ($muridList as $murid) {
            $perkembanganQuery = Perkembangan::where('murid_id', $murid->id);
            
            $perkembanganQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            
            $perkembanganList = $perkembanganQuery->latest('tanggal')->get();
            
            $latestPerAspek = [];
            foreach ($perkembanganList as $p) {
                if (!isset($latestPerAspek[$p->aspek]) || $p->tanggal > $latestPerAspek[$p->aspek]->tanggal) {
                    $latestPerAspek[$p->aspek] = $p;
                }
            }

            $hitung = $this->hitungPerkembangan($latestPerAspek);
            $tingkat = $murid->kelas?->tingkat ?? 'A';
            $statusWarna = $this->getStatusWarna($tingkat, $hitung['total_persentase']);

            $capaianPerMurid[$murid->id] = [
                'perkembangan' => $perkembanganList,
                'latest_per_aspek' => $latestPerAspek,
                'hitung' => $hitung,
                'tingkat' => $tingkat,
                'status_warna' => $statusWarna,
            ];
        }

        $listBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $listBulan[$i] = \Illuminate\Support\Carbon::create()->month($i)->translatedFormat('F');
        }
        
        $listTahun = [];
        $tahunSekarang = now()->year;
        for ($i = $tahunSekarang - 2; $i <= $tahunSekarang; $i++) {
            $listTahun[] = $i;
        }

        return view('guru.capaian-perkembangan.index', compact(
            'muridList', 
            'kelasList', 
            'capaianPerMurid', 
            'colorMap', 
            'skorLabels',
            'bulan',
            'tahun',
            'listBulan',
            'listTahun'
        ));
    }

    public function show($id, Request $request)
    {
        $murid = Murid::with('kelas')->findOrFail($id);
        
        $bulan = $request->filled('bulan') ? $request->integer('bulan') : null;
        $tahun = $request->filled('tahun') ? $request->integer('tahun') : null;
        
        $perkembanganQuery = Perkembangan::where('murid_id', $murid->id);
        
        if ($bulan && $tahun) {
            $perkembanganQuery->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }
        
        $perkembanganList = $perkembanganQuery->latest('tanggal')->get();
        
        $latestPerAspek = [];
        foreach ($perkembanganList as $p) {
            if (!isset($latestPerAspek[$p->aspek]) || $p->tanggal > $latestPerAspek[$p->aspek]->tanggal) {
                $latestPerAspek[$p->aspek] = $p;
            }
        }

        $hitung = $this->hitungPerkembangan($latestPerAspek);
        $tingkat = $murid->kelas?->tingkat ?? 'A';
        $kelompokUsia = $this->getKelompokUsia();
        $statusWarna = $this->getStatusWarna($tingkat, $hitung['total_persentase']);
        $kodePenilaian = $this->getKodePenilaian();
        $bagianPenilaian = $this->getBagianPenilaian();

        $narasi = $this->getNarasiOtomatis($tingkat);

        $totalBobot = $this->getTotalBobot();
        
        $listBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $listBulan[$i] = \Illuminate\Support\Carbon::create()->month($i)->translatedFormat('F');
        }
        
        $listTahun = [];
        $tahunSekarang = now()->year;
        for ($i = $tahunSekarang - 2; $i <= $tahunSekarang; $i++) {
            $listTahun[] = $i;
        }

        $riwayatPeriode = [];
        $allPerkembangan = Perkembangan::where('murid_id', $murid->id)
            ->latest('tanggal')
            ->get();
        
        $periodeList = [];
        foreach ($allPerkembangan as $p) {
            $key = $p->tanggal->format('Y-m');
            if (!in_array($key, $periodeList)) {
                $periodeList[] = $key;
            }
        }
        
        foreach ($periodeList as $periode) {
            list($th, $bln) = explode('-', $periode);
            $periodePerkembangan = $allPerkembangan->filter(function($p) use ($periode) {
                return $p->tanggal->format('Y-m') == $periode;
            });
            
            $latestPeriodeAspek = [];
            foreach ($periodePerkembangan as $p) {
                if (!isset($latestPeriodeAspek[$p->aspek]) || $p->tanggal > $latestPeriodeAspek[$p->aspek]->tanggal) {
                    $latestPeriodeAspek[$p->aspek] = $p;
                }
            }
            
            $hitungPeriode = $this->hitungPerkembangan($latestPeriodeAspek);
            $statusPeriode = $this->getStatusWarna($tingkat, $hitungPeriode['total_persentase']);
            
            $riwayatPeriode[] = [
                'periode' => \Illuminate\Support\Carbon::create()->year((int)$th)->month((int)$bln)->translatedFormat('F Y'),
                'bulan' => (int)$bln,
                'tahun' => (int)$th,
                'hitung' => $hitungPeriode,
                'status' => $statusPeriode,
            ];
        }

        // Pagination for riwayat periode
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage('riwayat_page');
        $perPage = 6;
        $total = count($riwayatPeriode);
        $currentPageItems = array_slice($riwayatPeriode, ($page - 1) * $perPage, $perPage);
        
        $riwayatPeriode = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'pageName' => 'riwayat_page']
        );

        return view('guru.capaian-perkembangan.show', compact(
            'murid',
            'perkembanganList',
            'latestPerAspek',
            'hitung',
            'tingkat',
            'kelompokUsia',
            'statusWarna',
            'kodePenilaian',
            'bagianPenilaian',
            'narasi',
            'totalBobot',
            'bulan',
            'tahun',
            'listBulan',
            'listTahun',
            'riwayatPeriode'
        ));
    }

    public function destroyRiwayat($id, $bulan, $tahun)
    {
        $murid = Murid::findOrFail($id);
        $bulan = (int)$bulan;
        $tahun = (int)$tahun;
        
        Perkembangan::where('murid_id', $murid->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->delete();
        
        return back()->with('success', 'Riwayat perkembangan bulan ' . \Illuminate\Support\Carbon::create()->month($bulan)->translatedFormat('F') . ' ' . $tahun . ' berhasil dihapus.');
    }
}
