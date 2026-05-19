@extends('layouts.app')

@section('title', 'Capaian Perkembangan - ' . $murid->nama_lengkap)

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <a href="{{ route('guru.capaian-perkembangan.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <h3 class="mb-0">Capaian Perkembangan</h3>
            <div class="text-muted">{{ $murid->nama_lengkap }}</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <form action="{{ route('guru.capaian-perkembangan.show', ['id' => $murid->id]) }}" method="GET" class="d-flex gap-2 align-items-center">
                <select name="bulan" class="form-select" style="width: 140px;">
                    <option value="">Semua Bulan</option>
                    @foreach($listBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan === $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="form-select" style="width: 100px;">
                    <option value="">Semua Tahun</option>
                    @foreach($listTahun as $th)
                        <option value="{{ $th }}" {{ $tahun === $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </form>
            <a href="{{ route('guru.perkembangan.create', ['murid_id' => $murid->id]) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Perkembangan
            </a>
        </div>
    </div>

    <div class="card mb-3" style="background-color: {{ $statusWarna['bg_color'] }}; border: 1px solid {{ $statusWarna['color'] }}40;">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-4">
                @php
                    $fotoPath = $murid->foto ? (str_starts_with($murid->foto, 'http') ? $murid->foto : asset('storage/' . $murid->foto)) : null;
                @endphp
                @if($fotoPath)
                    <img src="{{ $fotoPath }}" alt="Foto {{ $murid->nama_lengkap }}" class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px; border: 2px dashed #ddd;">
                        <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" style="width: 50px; height: 50px; object-fit: contain; opacity: 0.7;">
                    </div>
                @endif
                <div class="flex-grow-1">
                    <h5 class="mb-1 fw-bold">{{ $murid->nama_lengkap }}</h5>
                    <div class="text-muted small mb-1">
                        <span class="badge text-bg-{{ $murid->jenis_kelamin == 'L' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $murid->jenis_kelamin == 'L' ? 'primary' : 'danger' }} border-0 me-2">
                            {{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        {{ $murid->tanggal_lahir?->format('d M Y') ?? '-' }}
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-grid-3x3-gap me-1"></i>
                        {{ $murid->kelas?->nama_kelas ?? 'Belum ada kelas' }}
                    </div>
                    @if(isset($kelompokUsia[$tingkat]))
                        <div class="small mt-2">
                            <span class="badge" style="background-color: {{ $statusWarna['color'] }}20; color: {{ $statusWarna['color'] }};">
                                {{ $kelompokUsia[$tingkat]['label'] }} - {{ $kelompokUsia[$tingkat]['usia'] }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <div class="fw-bold" style="font-size: 2.5rem; color: {{ $statusWarna['color'] }};">
                            {{ $hitung['total_persentase'] }}%
                        </div>
                    <div class="small fw-semibold mb-2" style="color: {{ $statusWarna['color'] }};">
                            Total Persentase
                        </div>
                    @if(isset($kelompokUsia[$tingkat]))
                        <div class="small" style="background-color: {{ $statusWarna['color'] }}20; color: {{ $statusWarna['color'] }}; padding: 0.35rem 0.75rem; border-radius: 1rem; display: inline-block;">
                            ✅ STANDAR NILAI: TARGET AKHIR ≥{{ $kelompokUsia[$tingkat]['target'] }}% (SM / K)
                        </div>
                    @endif
                </div>
            </div>

            @if($narasi)
                <div class="p-4 rounded-4 bg-white border" style="border-color: {{ $statusWarna['color'] }}30;">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom" style="border-color: {{ $statusWarna['color'] }}20;">
                        <i class="bi bi-list-check fs-3" style="color: {{ $statusWarna['color'] }};"></i>
                        <div>
                            <div class="fw-bold" style="color: {{ $statusWarna['color'] }};">📋 Target Perkembangan</div>
                            <div class="text-muted small">{{ $narasi['judul'] }}</div>
                        </div>
                    </div>
                    
                    <div class="accordion" id="targetAccordion">
                        @foreach($narasi['bagian'] as $index => $bagian)
                            <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden" style="background-color: {{ $bagian['warna'] }}05; border: 1px solid {{ $bagian['warna'] }}20;">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}" style="background-color: transparent; box-shadow: none;">
                                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background-color: {{ $bagian['warna'] }}20; color: {{ $bagian['warna'] }};">
                                                <i class="bi {{ $bagian['icon'] }} fs-5"></i>
                                            </div>
                                            <div class="text-start flex-grow-1">
                                                <div class="fw-semibold" style="color: {{ $bagian['warna'] }};">{{ $bagian['nama'] }}</div>
                                                <div class="small text-muted">
                                                    Bobot: <span class="fw-semibold" style="color: {{ $bagian['warna'] }};">{{ $bagian['bobot'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#targetAccordion">
                                    <div class="accordion-body px-4 py-3">
                                        <ul class="mb-0" style="padding-left: 1.2rem;">
                                            @foreach($bagian['list'] as $item)
                                                <li class="mb-2 text-sm text-gray-700">
                                                    <i class="bi bi-check2-circle me-2" style="color: {{ $bagian['warna'] }};"></i>
                                                    {{ $item }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-calculator me-2"></i>Perhitungan Nilai
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                @foreach($bagianPenilaian as $bagian => $config)
                    @php
                        $nilaiBagian = $hitung['nilai_bagian'][$bagian] ?? null;
                    @endphp
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 border" style="border-color: {{ $config['color'] }}30; background-color: {{ $config['color'] }}05;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; background-color: {{ $config['color'] }}20; color: {{ $config['color'] }};">
                                    <i class="bi {{ $config['icon'] }}"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color: {{ $config['color'] }};">{{ $bagian }}</div>
                                    <div class="small text-muted">Bobot: {{ $config['bobot'] }}</div>
                                </div>
                            </div>
                            @if($nilaiBagian && $nilaiBagian['kode'])
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge" style="background-color: {{ $kodePenilaian[$nilaiBagian['kode']]['color'] }}20; color: {{ $kodePenilaian[$nilaiBagian['kode']]['color'] }};">
                                                {{ $nilaiBagian['kode'] }} ({{ $kodePenilaian[$nilaiBagian['kode']]['label'] }})
                                            </span>
                                        <span class="fw-semibold" style="color: {{ $config['color'] }};">{{ number_format($nilaiBagian['nilai'], 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $nilaiBagian['persentase_kode'] }}%; background-color: {{ $config['color'] }};"></div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-2 text-muted small">
                                    <i class="bi bi-clock me-1"></i>Belum dinilai
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if(isset($kelompokUsia[$tingkat]))
                @php
                    $target = $kelompokUsia[$tingkat]['target'];
                    $tercapai = $hitung['total_persentase'] >= $target;
                @endphp
                <div class="p-4 rounded-4 border" style="background-color: {{ $tercapai ? '#dcfce7' : '#fef3c7' }}; border-color: {{ $tercapai ? '#86efac' : '#fcd34d' }};">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background-color: {{ $tercapai ? '#10b981' : '#f59e0b' }}; color: white;">
                                <i class="bi {{ $tercapai ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }} fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="color: {{ $tercapai ? '#16a34a' : '#d97706' }};">
                                    {{ $tercapai ? '✅ Tercapai' : '⚠️ Belum Tercapai' }}
                                </div>
                                <div class="small" style="color: {{ $tercapai ? '#16a34a' : '#d97706' }};">
                                    Standar {{ $kelompokUsia[$tingkat]['label'] }}
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold fs-4" style="color: {{ $tercapai ? '#16a34a' : '#d97706' }};">
                                {{ $hitung['total_persentase'] }}%
                            </div>
                            <div class="small" style="color: {{ $tercapai ? '#16a34a' : '#d97706' }};">
                                Target: ≥{{ $target }}%
                            </div>
                        </div>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ min($hitung['total_persentase'], 100) }}%; background: {{ $tercapai ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)' }};" aria-valuenow="{{ $hitung['total_persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2 small" style="color: {{ $tercapai ? '#16a34a' : '#d97706' }};">
                        <span>Total Nilai: {{ number_format($hitung['total_nilai'], 2) }} / {{ $totalBobot }}</span>
                        <span>{{ $tercapai ? 'Capaian sudah memenuhi standar!' : 'Butuh peningkatan untuk mencapai standar!' }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(count($latestPerAspek) > 0)
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-check-circle me-2"></i>Capaian Terbaru per Bagian
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($bagianPenilaian as $bagian => $config)
                        @php
                            $nilaiBagian = $hitung['nilai_bagian'][$bagian] ?? null;
                        $p = $latestPerAspek[$bagian] ?? null;
                        if (!$p) continue;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px; background-color: {{ $config['color'] }}10;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="aspek-icon-box" style="width: 44px; height: 44px; background: {{ $config['color'] }}20; color: {{ $config['color'] }};">
                                                    <i class="bi {{ $config['icon'] }}"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $bagian }}</h6>
                                            </div>
                                            @if($nilaiBagian && $nilaiBagian['kode'])
                                                <span class="badge rounded-pill border-0 px-3 py-1 fw-bold" style="font-size: 0.75rem; background-color: {{ $kodePenilaian[$nilaiBagian['kode']]['color'] }}20; color: {{ $kodePenilaian[$nilaiBagian['kode']]['color'] }}; border: 1px solid {{ $kodePenilaian[$nilaiBagian['kode']]['color'] }}40;">
                                                    {{ $kodePenilaian[$nilaiBagian['kode']]['short'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.5;">{{ Str::limit($p->catatan, 120) }}</p>
                                        <div class="d-flex align-items-center justify-content-between mt-3" style="font-size: 0.75rem;">
                                            <span class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $p->tanggal?->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($riwayatPeriode->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Perkembangan (Per Bulan)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($riwayatPeriode as $riwayat)
                            <div class="col-md-4">
                                <div class="p-3 rounded-4 border" style="border-color: {{ $riwayat['status']['color'] }}30; background-color: {{ $riwayat['status']['color'] }}05;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="fw-semibold" style="color: {{ $riwayat['status']['color'] }};">
                                            <i class="bi bi-calendar-check me-1"></i>{{ $riwayat['periode'] }}
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('guru.capaian-perkembangan.show', ['id' => $murid->id, 'bulan' => $riwayat['bulan'], 'tahun' => $riwayat['tahun']]) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form class="d-inline" method="POST" action="{{ route('guru.capaian-perkembangan.destroy-riwayat', ['id' => $murid->id, 'bulan' => $riwayat['bulan'], 'tahun' => $riwayat['tahun']]) }}"
                                                  onsubmit="return confirm('Hapus seluruh riwayat perkembangan bulan {{ $riwayat['periode'] }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $riwayat['hitung']['total_persentase'] }}%; background-color: {{ $riwayat['status']['color'] }};" aria-valuenow="{{ $riwayat['hitung']['total_persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="small fw-semibold" style="color: {{ $riwayat['status']['color'] }};">{{ $riwayat['hitung']['total_persentase'] }}%</span>
                                        <span class="small text-muted">Total: {{ number_format($riwayat['hitung']['total_nilai'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($riwayatPeriode->hasPages())
                    <div class="mt-3">
                        {{ $riwayatPeriode->links() }}
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="fw-semibold"><i class="bi bi-journal-text me-2"></i>Riwayat Perkembangan</div>
                <div class="text-muted small">Total: {{ $perkembanganList->count() }}</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">Tanggal</th>
                                <th>Bagian</th>
                                <th>Capaian</th>
                                <th>Catatan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perkembanganList as $p)
                            <tr>
                                <td class="text-nowrap">{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                                <td class="fw-semibold small">{{ $p->aspek }}</td>
                                <td>
                                    @if($p->skor && isset($kodePenilaian[$p->skor]))
                                    <span class="badge rounded-pill px-3" style="background-color: {{ $kodePenilaian[$p->skor]['color'] }}20; color: {{ $kodePenilaian[$p->skor]['color'] }}; border: 1px solid {{ $kodePenilaian[$p->skor]['color'] }}40; font-size: 0.75rem;">
                                        {{ $kodePenilaian[$p->skor]['short'] }}
                                    </span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="text-truncate" style="max-width: 320px;">{{ $p->catatan }}</td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('guru.perkembangan.edit', $p) }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form class="d-inline" method="POST" action="{{ route('guru.perkembangan.destroy', $p) }}" onsubmit="return confirm('Hapus catatan perkembangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada riwayat perkembangan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection
