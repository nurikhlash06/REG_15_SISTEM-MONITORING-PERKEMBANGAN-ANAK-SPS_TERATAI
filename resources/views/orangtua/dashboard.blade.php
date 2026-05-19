@extends('layouts.parent_mobile')

@section('title', 'Dashboard Orang Tua')

@section('content')
    @if(isset($dynamicStyles))
        <style>{{ $dynamicStyles }}</style>
    @endif
    <!-- Welcome Header -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div>
            @php $firstName = explode(' ', $user->name)[0]; @endphp
            <h4 class="fw-bold mb-1 text-dark">Halo, {{ $firstName }}! 👋</h4>
            <p class="text-muted small mb-0">Mari lihat perkembangan si kecil hari ini.</p>
        </div>
        <div class="position-relative">
            <div class="rounded-circle shadow-sm p-1 bg-white" style="border: 2px solid #6c5ce7;">
                <div class="user-avatar-header m-0" style="width: 48px; height: 48px; font-size: 1.2rem; background: linear-gradient(135deg, #6c5ce7, #a29bfe);">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary Section -->
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="bg-soft-purple rounded-circle p-2">
                            <i class="bi bi-people-fill text-purple"></i>
                        </div>
                        <span class="text-muted small fw-bold">Anak Saya</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h3 class="fw-bold text-dark mb-0">{{ $stats['total_anak'] }}</h3>
                        <span class="text-muted small">Anak</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="bg-soft-pink rounded-circle p-2">
                            <i class="bi bi-journal-check text-pink"></i>
                        </div>
                        <span class="text-muted small fw-bold">Laporan Bulan Ini</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        @php $total_perkembangan = $anak->sum('total_perkembangan'); @endphp
                        <h3 class="fw-bold text-dark mb-0">{{ $total_perkembangan }}</h3>
                        <span class="text-muted small">Catatan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Anak Saya Section -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold mb-0 text-dark">Profil Anak</h6>
            <a href="{{ route('orangtua.perkembangan.index') }}" class="text-primary small text-decoration-none fw-bold">Lihat Laporan <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="d-flex gap-3 overflow-auto pb-2 px-1" style="scrollbar-width: none; -ms-overflow-style: none;">
            @forelse($anak as $a)
                <div class="flex-shrink-0" style="width: 300px;">
                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                        <a href="{{ route('orangtua.perkembangan.index', ['murid_id' => $a->id]) }}" class="text-decoration-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        @php
                                            $fotoPath = $a->foto ? (str_starts_with($a->foto, 'http') ? $a->foto : asset('storage/' . $a->foto)) : null;
                                        @endphp
                                        @if($fotoPath)
                                            <img src="{{ $fotoPath }}" alt="Foto" class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px; border: 2px dashed #ddd;">
                                                <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" style="width: 55px; height: 55px; object-fit: contain; opacity: 0.7;">
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 bg-success border-2 border-white rounded-circle" style="width: 16px; height: 16px;"></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-1">{{ $a->nama_lengkap }}</h6>
                                        @if(!empty($a->nama_kelas))
                                            <div class="mb-1">
                                                <span class="badge bg-soft-purple text-purple rounded-pill px-2 py-1 fw-normal" style="font-size: 0.7rem;">
                                                    <i class="bi bi-house-door me-1"></i>{{ $a->nama_kelas }}
                                                </span>
                                            </div>
                                        @endif
                                        @if(isset($a->standar_nilai))
                                            <div class="mb-1">
                                                <span class="badge rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem; background-color: {{ $a->standar_nilai['status_warna']['hijau'] }}20; color: {{ $a->standar_nilai['status_warna']['hijau'] }}; border: 1px solid {{ $a->standar_nilai['status_warna']['hijau'] }}40;">
                                                    ✅ Target: ≥{{ $a->standar_nilai['target'] }}%
                                                </span>
                                            </div>
                                        @endif
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            <span class="badge bg-soft-primary text-primary rounded-pill px-2 py-1 fw-normal" style="font-size: 0.7rem;">
                                                <i class="bi bi-journal-text me-1"></i>{{ $a->total_perkembangan ?? 0 }} Lap.
                                            </span>
                                            @if($a->berat_badan > 0)
                                                <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1 fw-normal" style="font-size: 0.7rem;">
                                                    <i class="bi bi-speedometer2 me-1"></i>{{ $a->berat_badan }}kg
                                                </span>
                                            @endif
                                            @if($a->tinggi_badan > 0)
                                                <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 fw-normal" style="font-size: 0.7rem;">
                                                    <i class="bi bi-rulers me-1"></i>{{ $a->tinggi_badan }}cm
                                                </span>
                                            @endif
                                        </div>
                                        @if(isset($a->total_persentase))
                                            <div class="mt-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="flex-grow-1">
                                                        <div class="progress" style="height: 6px; border-radius: 10px; background: rgba(0,0,0,0.05);">
                                                            @php
                                                                $persentase = $a->total_persentase ?? 0;
                                                                $target = $a->standar_nilai['target'] ?? 75;
                                                                $statusWarna = $a->standar_nilai['status_warna'] ?? ['hijau' => '#10b981'];
                                                                $warnaProgress = $persentase >= $target ? $statusWarna['hijau'] : ($persentase >= ($target - 10) ? $statusWarna['kuning'] : $statusWarna['merah']);
                                                            @endphp
                                                            <div class="progress-bar" role="progressbar" style="width:{{ $persentase }}%; background-color: {{ $warnaProgress }}; border-radius: 10px;"></div>
                                                        </div>
                                                    </div>
                                                    <span class="fw-bold text-dark" style="font-size: 0.85rem; min-width: 45px;">{{ $persentase }}%</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($a->best_aspek)
                                            <div class="mt-2">
                                                <div class="text-muted small mb-1" style="font-size: 0.65rem;">Capaian Terbaik:</div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <div class="badge bg-soft-warning text-warning rounded-pill px-2 py-1 fw-bold" style="font-size: 0.65rem;">
                                                        <i class="bi bi-star-fill me-1"></i>{{ $a->best_aspek }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-muted">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="w-100 text-center py-4 bg-white rounded-4 border border-dashed">
                    <p class="text-muted small mb-0">Belum ada data anak yang terhubung.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Monthly Chart -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Aktivitas Belajar</h6>
                    <p class="text-muted small mb-0">6 bulan terakhir</p>
                </div>
                <div class="bg-soft-success rounded-pill px-3 py-1">
                    <span class="text-success fw-bold small" style="font-size: 0.7rem;">Trend Positif</span>
                </div>
            </div>
            <div class="card-body p-3">
                <div id="chart-container" data-labels="{{ json_encode($chartPerBulan['labels'] ?? []) }}" data-values="{{ json_encode($chartPerBulan['data'] ?? []) }}">
                    <div style="height: 220px;">
                        <canvas id="chart-anak"></canvas>
                    </div>
                </div>
                <div class="mt-3 p-2 bg-light rounded-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle text-primary mt-1"></i>
                        <p class="text-muted mb-0" style="font-size: 0.7rem; line-height: 1.4;">
                            Grafik ini menunjukkan intensitas kegiatan belajar anak Anda. 
                            <strong>Semakin tinggi titik grafik</strong>, semakin banyak aktivitas yang dicatat oleh guru pada bulan tersebut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Target Perkembangan Section -->
    <div class="mb-4">
        @if($anak->count() > 1)
            <!-- Tabs for multiple children -->
            <ul class="nav nav-pills gap-2 mb-3 px-1 overflow-auto flex-nowrap pb-2" id="childTargetTabs" role="tablist" style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach($anak as $index => $a)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-3 py-1 small fw-bold {{ $index == 0 ? 'active' : '' }}" 
                                id="child-target-tab-{{ $a->id }}" 
                                data-bs-toggle="pill" 
                                data-bs-target="#child-target-{{ $a->id }}" 
                                type="button" 
                                role="tab" 
                                style="font-size: 0.75rem; white-space: nowrap;">
                            {{ explode(' ', $a->nama_lengkap)[0] }}
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="tab-content" id="childTargetTabsContent">
            @foreach($anak as $index => $a)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="child-target-{{ $a->id }}" role="tabpanel">
                    @if($a->target_perkembangan)
                        <div class="p-4 rounded-4 bg-white border" style="border-color: #6c5ce730;">
                            <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom" style="border-color: #6c5ce720;">
                                <i class="bi bi-list-check fs-3" style="color: #6c5ce7;"></i>
                                <div>
                                    <div class="fw-bold" style="color: #6c5ce7;">📋 Target Perkembangan</div>
                                    <div class="text-muted small">{{ $a->target_perkembangan['judul'] ?? '' }}</div>
                                </div>
                            </div>
                            
                            <div class="accordion" id="targetAccordion{{ $a->id }}">
                                @foreach($a->target_perkembangan['bagian'] ?? [] as $bagianIndex => $bagian)
                                    <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden" style="background-color: {{ $bagian['warna'] ?? '#6c5ce7' }}05; border: 1px solid {{ $bagian['warna'] ?? '#6c5ce7' }}20;">
                                        <h2 class="accordion-header" id="heading{{ $a->id }}{{ $bagianIndex }}">
                                            <button class="accordion-button collapsed p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $a->id }}{{ $bagianIndex }}" aria-expanded="false" aria-controls="collapse{{ $a->id }}{{ $bagianIndex }}" style="background-color: transparent; box-shadow: none;">
                                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background-color: {{ $bagian['warna'] ?? '#6c5ce7' }}20; color: {{ $bagian['warna'] ?? '#6c5ce7' }};">
                                                        <i class="bi {{ $bagian['icon'] ?? 'bi-star' }} fs-5"></i>
                                                    </div>
                                                    <div class="text-start flex-grow-1">
                                                        <div class="fw-semibold" style="color: {{ $bagian['warna'] ?? '#6c5ce7' }};">{{ $bagian['nama'] ?? '' }}</div>
                                                        <div class="small text-muted">
                                                            Bobot: <span class="fw-semibold" style="color: {{ $bagian['warna'] ?? '#6c5ce7' }};">{{ $bagian['bobot'] ?? 0 }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $a->id }}{{ $bagianIndex }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $a->id }}{{ $bagianIndex }}" data-bs-parent="#targetAccordion{{ $a->id }}">
                                            <div class="accordion-body px-4 py-3">
                                                <ul class="mb-0" style="padding-left: 1.2rem;">
                                                    @foreach($bagian['list'] ?? [] as $item)
                                                        <li class="mb-2 text-sm text-gray-700">
                                                            <i class="bi bi-check2-circle me-2" style="color: {{ $bagian['warna'] ?? '#6c5ce7' }};"></i>
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
            @endforeach
        </div>
    </div>

    <!-- Perhitungan Nilai Section -->
    <div class="mb-4">
        @if($anak->count() > 1)
            <!-- Tabs for multiple children -->
            <ul class="nav nav-pills gap-2 mb-3 px-1 overflow-auto flex-nowrap pb-2" id="childPerhitunganTabs" role="tablist" style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach($anak as $index => $a)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-3 py-1 small fw-bold {{ $index == 0 ? 'active' : '' }}" 
                                id="child-perhitungan-tab-{{ $a->id }}" 
                                data-bs-toggle="pill" 
                                data-bs-target="#child-perhitungan-{{ $a->id }}" 
                                type="button" 
                                role="tab" 
                                style="font-size: 0.75rem; white-space: nowrap;">
                            {{ explode(' ', $a->nama_lengkap)[0] }}
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="tab-content" id="childPerhitunganTabsContent">
            @foreach($anak as $index => $a)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="child-perhitungan-{{ $a->id }}" role="tabpanel">
                    @if($a->hitung && $a->bagian_penilaian && $a->kode_penilaian)
                        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">Perhitungan Nilai</h6>
                                    <p class="text-muted small mb-0">{{ $a->nama_lengkap }}</p>
                                </div>
                                <div class="badge bg-white text-dark shadow-sm border-0 rounded-pill px-3 py-2 fw-normal">
                                    <i class="bi bi-calendar3 text-primary me-1"></i> {{ now()->translatedFormat('F Y') }}
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    @foreach($a->bagian_penilaian as $bagian => $config)
                                        @php
                                            $nilaiBagian = $a->hitung['nilai_bagian'][$bagian] ?? null;
                                            $kode = $nilaiBagian ? $nilaiBagian['kode'] : null;
                                            $kodeInfo = $kode && isset($a->kode_penilaian[$kode]) ? $a->kode_penilaian[$kode] : null;
                                            $nilai = $nilaiBagian ? $nilaiBagian['nilai'] : 0;
                                        @endphp
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3 border" style="background-color: {{ $config['color'] }}10; border-color: {{ $config['color'] }}30;">
                                                <h6 class="fw-semibold mb-2" style="color: {{ $config['color'] }};">
                                                    <i class="bi {{ $config['icon'] }} me-1"></i>{{ $bagian }}
                                                </h6>
                                                <div class="mb-1">
                                                    <span class="text-muted small" style="font-size: 0.7rem;">Bobot:</span>
                                                    <span class="fw-semibold ms-1">{{ $config['bobot'] }}</span>
                                                </div>
                                                @if($kodeInfo)
                                                    <div class="mb-1">
                                                        <span class="badge text-light px-2 py-1" style="background-color: {{ $kodeInfo['color'] }}; border-radius: 6px; font-size: 0.7rem;">
                                                            {{ $kodeInfo['short'] }} ({{ $kodeInfo['full'] }})
                                                        </span>
                                                    </div>
                                                    <div class="fw-bold text-dark" style="font-size: 1.2rem;">
                                                        {{ number_format($nilai, 2) }}
                                                    </div>
                                                @else
                                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                                        <i class="bi bi-info-circle me-1"></i>Belum ada penilaian
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-0">Total Nilai</h6>
                                            <p class="text-muted small mb-0">
                                                {{ number_format($a->hitung['total_nilai'], 2) }} / {{ $totalBobot }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-primary" style="font-size: 1.8rem;">
                                                {{ $a->hitung['total_persentase'] }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
<style>
    .bg-soft-primary { background-color: rgba(108, 92, 231, 0.1) !important; }
    .bg-soft-success { background-color: rgba(0, 184, 148, 0.1) !important; }
    .bg-soft-purple { background-color: rgba(108, 92, 231, 0.1) !important; }
    .bg-soft-pink { background-color: rgba(217, 70, 239, 0.1) !important; }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1) !important; }
    .bg-soft-info { background-color: rgba(14, 165, 233, 0.1) !important; }
    .text-purple { color: #6c5ce7 !important; }
    .text-pink { color: #d946ef !important; }
    .bg-soft-blue { background-color: rgba(9, 132, 227, 0.1) !important; }
    .bg-soft-green { background-color: rgba(85, 239, 196, 0.1) !important; }
    .bg-soft-yellow { background-color: rgba(253, 203, 110, 0.1) !important; }
    .bg-soft-red { background-color: rgba(214, 48, 49, 0.1) !important; }

    .text-purple { color: #6c5ce7 !important; }
    .text-pink { color: #d63031 !important; }
    .text-blue { color: #0984e3 !important; }
    .text-green { color: #00b894 !important; }
    .text-yellow { color: #fdcb6e !important; }
    .text-red { color: #e17055 !important; }

    .card:active {
        transform: scale(0.98);
    }
    
    .aspect-icon i {
        font-weight: bold;
    }

    /* Hide scrollbar but allow scrolling */
    .overflow-auto::-webkit-scrollbar {
        display: none;
    }
    .overflow-auto {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartContainer = document.getElementById('chart-container');
            if (!chartContainer) return;

            const ctx = document.getElementById('chart-anak').getContext('2d');
            const labels = JSON.parse(chartContainer.dataset.labels || '[]');
            const dataValues = JSON.parse(chartContainer.dataset.values || '[]');

            if (labels.length === 0) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Aktivitas',
                        data: dataValues,
                        borderColor: '#6c5ce7',
                        backgroundColor: 'rgba(108, 92, 231, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6c5ce7',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#6c5ce7',
                        pointHoverBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#2d3436',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '📊 ' + context.parsed.y + ' Aktivitas Belajar';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(...dataValues) + 2,
                            ticks: {
                                stepSize: 1,
                                font: { size: 10, weight: '500' },
                                color: '#a0aec0'
                            },
                            grid: { color: '#f1f2f6', drawBorder: false }
                        },
                        x: {
                            ticks: {
                                font: { size: 10, weight: '500' },
                                color: '#a0aec0'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endpush
