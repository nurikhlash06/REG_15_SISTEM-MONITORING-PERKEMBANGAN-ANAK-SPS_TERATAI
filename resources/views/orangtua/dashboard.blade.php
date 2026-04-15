@extends('layouts.parent_mobile')

@section('title', 'Dashboard Orang Tua')

@section('content')
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

    <!-- Daily Tip Card -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    {{ $dailyTip['icon'] }}
                </div>
                <div>
                    <h6 class="fw-bold text-primary mb-1" style="font-size: 0.85rem;">{{ $dailyTip['title'] }}</h6>
                    <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.4;">{{ $dailyTip['content'] }}</p>
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
                <div class="flex-shrink-0" style="width: 280px;">
                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                        <a href="{{ route('orangtua.perkembangan.index', ['murid_id' => $a->id]) }}" class="text-decoration-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        @if(!empty($a->foto))
                                            <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #eee;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border: 2px solid #eee;">
                                                <i class="bi bi-person text-secondary fs-3"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 14px; height: 14px;"></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-1">{{ $a->nama_lengkap }}</h6>
                                        @if(!empty($a->nama_kelas))
                                            <div class="mb-1">
                                                <span class="badge bg-soft-purple text-purple rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem;">
                                                    <i class="bi bi-house-door me-1"></i>{{ $a->nama_kelas }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            <span class="badge bg-soft-primary text-primary rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem;">
                                                <i class="bi bi-journal-text me-1"></i>{{ $a->total_perkembangan ?? 0 }} Lap.
                                            </span>
                                            @if($a->berat_badan > 0)
                                                <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem;">
                                                    <i class="bi bi-speedometer2 me-1"></i>{{ $a->berat_badan }}kg
                                                </span>
                                            @endif
                                            @if($a->tinggi_badan > 0)
                                                <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem;">
                                                    <i class="bi bi-rulers me-1"></i>{{ $a->tinggi_badan }}cm
                                                </span>
                                            @endif
                                            @if($a->lingkar_kepala > 0)
                                                <span class="badge bg-soft-info text-info rounded-pill px-2 py-1 fw-normal" style="font-size: 0.65rem;">
                                                    <i class="bi bi-rulers me-1"></i>{{ $a->lingkar_kepala }}cm
                                                </span>
                                            @endif
                                        </div>
                                        @if($a->best_aspek)
                                            <div class="mt-2">
                                                <div class="text-muted small mb-1" style="font-size: 0.6rem;">Capaian Terbaik:</div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <div class="badge bg-soft-warning text-warning rounded-pill px-2 py-1 fw-bold" style="font-size: 0.6rem;">
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

    <!-- Chart & Aspect Section -->
    <div class="row g-4 mb-4">
        <!-- Monthly Chart -->
        <div class="col-12">
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

        <!-- Development Aspects -->
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Aspek Capaian</h6>
                    <p class="text-muted small mb-0">Rata-rata perkembangan bulan ini</p>
                </div>
                <div class="badge bg-white text-dark shadow-sm border-0 rounded-pill px-3 py-2 fw-normal">
                    <i class="bi bi-calendar3 text-primary me-1"></i> {{ now()->translatedFormat('F') }}
                </div>
            </div>

            @if($anak->count() > 1)
                <!-- Tabs for multiple children -->
                <ul class="nav nav-pills gap-2 mb-3 px-1 overflow-auto flex-nowrap pb-2" id="childAspectTabs" role="tablist" style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach($anak as $index => $a)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-3 py-1 small fw-bold {{ $index == 0 ? 'active' : '' }}" 
                                    id="child-tab-{{ $a->id }}" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#child-aspect-{{ $a->id }}" 
                                    type="button" 
                                    role="tab" 
                                    style="font-size: 0.75rem; white-space: nowrap;">
                                {{ explode(' ', $a->nama_lengkap)[0] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="tab-content" id="childAspectTabsContent">
                @foreach($anak as $index => $a)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="child-aspect-{{ $a->id }}" role="tabpanel">
                        <div class="row g-3">
                            @forelse($a->aspek_stats as $stat)
                                @php
                                    $aspekClass = match(true) {
                                        str_contains($stat->name, 'Agama') => 'aspek-agama',
                                        str_contains($stat->name, 'Fisik') => 'aspek-fisik',
                                        str_contains($stat->name, 'Kognitif') => 'aspek-kognitif',
                                        str_contains($stat->name, 'Bahasa') => 'aspek-bahasa',
                                        str_contains($stat->name, 'Sosial') => 'aspek-sosial',
                                        str_contains($stat->name, 'Seni') => 'aspek-seni',
                                        default => ''
                                    };
                                @endphp
                                <div class="col-6">
                                    <div class="card border-0 shadow-sm h-100 {{ $aspekClass }}" style="border-radius: 20px; transition: transform 0.2s;">
                                        <a href="{{ route('orangtua.perkembangan.index', ['murid_id' => $a->id, 'aspek' => $stat->name]) }}" class="text-decoration-none h-100 d-flex flex-column">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="aspek-icon-box bg-aspek text-aspek">
                                                        <i class="bi {{ $stat->styles['icon'] }}" style="font-size: 0.9rem;"></i>
                                                    </div>
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.75rem;">{{ $stat->name }}</h6>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    @php
                                                        $percentNum = (int)$stat->percent;
                                                        $percentDisplay = "{$percentNum}%";
                                                        $percentWidthStyle = "width:{$percentNum}%";
                                                    @endphp
                                                    <div class="d-flex align-items-baseline gap-1">
                                                        <span class="fw-bold text-dark" style="font-size: 1.1rem;">{{ $percentDisplay }}</span>
                                                        <span class="text-muted" style="font-size: 0.6rem;">Capaian</span>
                                                    </div>
                                                    <div class="progress" style="height: 5px; border-radius: 10px; background: #f0f0f0;">
                                                        <div class="progress-bar progress-aspek" role="progressbar" style="<?php echo $percentWidthStyle; ?>"></div>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="badge rounded-pill badge-aspek" style="font-size: 0.6rem;">
                                                        {{ $stat->status }}
                                                    </span>
                                                    <span class="text-muted" style="font-size: 0.6rem;">{{ $stat->count }} Lap.</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm text-center py-4" style="border-radius: 20px;">
                                        <p class="text-muted small mb-0">Belum ada data perkembangan bulan ini.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
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