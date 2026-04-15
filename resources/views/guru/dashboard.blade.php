@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <!-- Greeting Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 p-md-5 text-white position-relative">
                    <div class="position-relative z-index-1">
                        <h2 class="fw-bold mb-1">{{ $greeting }}, {{ $user->name }}! 👋</h2>
                        <p class="opacity-75 mb-4">Hari yang cerah untuk mendidik generasi bangsa. Berikut ringkasan kegiatan hari ini.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('guru.perkembangan.create') }}" class="btn btn-outline-white rounded-pill px-4 fw-bold shadow-sm hover-up">
                                <i class="bi bi-plus-circle me-2"></i>Input Capaian Baru
                            </a>
                            <a href="{{ route('guru.murid.index') }}" class="btn btn-outline-white rounded-pill px-4 fw-bold shadow-sm hover-up">
                                <i class="bi bi-people me-2"></i>Lihat Semua Murid
                            </a>
                        </div>
                    </div>
                    <!-- Decorative shapes -->
                    <div class="position-absolute end-0 bottom-0 opacity-25 d-none d-md-block" style="transform: translate(10%, 10%);">
                        <i class="bi bi-sun" style="font-size: 15rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-3 mb-4" 
         id="dashboard-stats"
         data-aspek-labels="{{ json_encode($chartAspek['labels'] ?? []) }}"
         data-aspek-values="{{ json_encode($chartAspek['data'] ?? []) }}"
         data-aspek-colors="{{ json_encode(collect($chartAspek['labels'])->map(fn($label) => $colorMap[$label]['text'] ?? '#4361ee')) }}"
         data-bulan-labels="{{ json_encode($chartBulanan['labels'] ?? []) }}"
         data-bulan-values="{{ json_encode($chartBulanan['data'] ?? []) }}">
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 card-stat bg-soft-primary" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-shape bg-primary text-white rounded-circle mb-3 mx-auto shadow-sm">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_murid'] }}</h3>
                    <p class="text-muted small fw-medium mb-0">Total Murid</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 card-stat bg-soft-success" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-shape bg-success text-white rounded-circle mb-3 mx-auto shadow-sm">
                        <i class="bi bi-house-door-fill fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_kelas'] }}</h3>
                    <p class="text-muted small fw-medium mb-0">Total Rombel</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 card-stat bg-soft-warning" style="border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-shape bg-warning text-white rounded-circle mb-3 mx-auto shadow-sm">
                        <i class="bi bi-journal-text fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_perkembangan'] }}</h3>
                    <p class="text-muted small fw-medium mb-1">Catatan Bulan Ini</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 card-stat bg-soft-info" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="text-muted small fw-bold mb-0">Update Bulan Ini</p>
                        <span class="badge bg-info rounded-pill">{{ $stats['progress_bulan_ini']['percentage'] }}%</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">{{ $stats['progress_bulan_ini']['count'] }} <small class="text-muted fs-6">/ {{ $stats['total_murid'] }} Murid</small></h4>
                    <div class="progress" style="height: 8px; border-radius: 10px; background-color: rgba(0,0,0,0.05);">
                        @php 
                            $pctWidth = (int)($stats['progress_bulan_ini']['percentage'] ?? 0);
                            $pctStyle = "width:{$pctWidth}%";
                        @endphp
                        <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" 
                             role="progressbar" 
                             style="<?php echo $pctStyle; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fisik Stats Section -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-white" style="border-radius: 20px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-soft-danger text-danger rounded-4 p-3 shadow-sm">
                        <i class="bi bi-speedometer2 fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-bold mb-0">Rata-rata BB</p>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['fisik']['avg_bb'] }} <small class="text-muted fs-6">kg</small></h4>
                        <small class="text-muted" style="font-size: 0.65rem;">Dari {{ $stats['fisik']['count_bb'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-white" style="border-radius: 20px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-soft-success text-success rounded-4 p-3 shadow-sm">
                        <i class="bi bi-rulers fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-bold mb-0">Rata-rata TB</p>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['fisik']['avg_tb'] }} <small class="text-muted fs-6">cm</small></h4>
                        <small class="text-muted" style="font-size: 0.65rem;">Dari {{ $stats['fisik']['count_tb'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-white" style="border-radius: 20px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-soft-info text-info rounded-4 p-3 shadow-sm">
                        <i class="bi bi-rulers fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-bold mb-0">Rata-rata LK</p>
                        <h4 class="fw-bold text-dark mb-0">{{ $stats['fisik']['avg_lk'] }} <small class="text-muted fs-6">cm</small></h4>
                        <small class="text-muted" style="font-size: 0.65rem;">Dari {{ $stats['fisik']['count_lk'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Main Chart Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Statistik Capaian Aspek</h6>
                        <span class="badge bg-light text-dark border-0 fw-normal rounded-pill px-3">Bulan {{ now()->translatedFormat('F') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height: 320px;">
                        <canvas id="chart-aspek"></canvas>
                    </div>
                    @if(empty($chartAspek['labels']))
                        <div class="text-center py-5">
                            <i class="bi bi-database-exclamation fs-1 text-muted opacity-25"></i>
                            <p class="text-muted mt-2">Belum ada data perkembangan yang diinput bulan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-lightning-fill me-2 text-warning"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <a href="{{ route('guru.murid.create') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-none hover-action" style="border-radius: 15px; background: #f0f4ff;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                        <i class="bi bi-person-plus-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Tambah Murid</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Daftarkan siswa baru</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.orangtua.create') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-none hover-action" style="border-radius: 15px; background: #fff8f0;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                        <i class="bi bi-people-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Akun Orang Tua</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Kelola akses wali murid</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.perkembangan.create') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-none hover-action" style="border-radius: 15px; background: #f0fff4;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                        <i class="bi bi-journal-plus fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Input Capaian</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Catat progres anak</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.murid.index') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-none hover-action" style="border-radius: 15px; background: #fdf0ff;">
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-purple text-purple rounded-3 p-2 me-3">
                                        <i class="bi bi-people-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Daftar Murid</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Lihat semua data siswa</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Recent Activities & Monthly Chart -->
    <div class="row g-4">
        <!-- Recent Activity List -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history me-2 text-info"></i>Aktivitas Terbaru</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="timeline-simple">
                        @forelse($recentActivities as $activity)
                            <div class="timeline-item d-flex gap-3 mb-4">
                                @php
                                    $styles = $colorMap[$activity->aspek] ?? [
                                        'icon' => 'bi-pencil-square',
                                        'text' => '#64748b',
                                        'icon_bg' => 'rgba(0,0,0,0.05)'
                                    ];
                                @endphp
                                @php
                                    $aspekClass = match(true) {
                                        str_contains($activity->aspek, 'Agama') => 'aspek-agama',
                                        str_contains($activity->aspek, 'Fisik') => 'aspek-fisik',
                                        str_contains($activity->aspek, 'Kognitif') => 'aspek-kognitif',
                                        str_contains($activity->aspek, 'Bahasa') => 'aspek-bahasa',
                                        str_contains($activity->aspek, 'Sosial') => 'aspek-sosial',
                                        str_contains($activity->aspek, 'Seni') => 'aspek-seni',
                                        default => ''
                                    };
                                @endphp
                                <div class="aspek-icon-box bg-aspek text-aspek flex-shrink-0 {{ $aspekClass }}" 
                                     style="width: 40px; height: 40px;">
                                    <i class="bi {{ $styles['icon'] }}"></i>
                                </div>
                                <div class="timeline-content border-bottom pb-3 w-100">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold text-dark small mb-0">{{ $activity->nama_murid }}</h6>
                                        <span class="text-muted" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-muted small mb-0">Update aspek <strong>{{ $activity->aspek }}</strong></p>
                                    <div class="d-flex align-items-center gap-1 mt-1">
                                        @for($i = 1; $i <= 4; $i++)
                                            <i class="bi bi-star-fill" style="font-size: 0.6rem; color: {{ $i <= $activity->skor ? '#ffc107' : '#e9ecef' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-activity fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-2 small">Belum ada aktivitas tercatat.</p>
                            </div>
                        @endforelse
                    </div>
                    @if($recentActivities->isNotEmpty())
                        <div class="text-center mt-2">
                            <a href="{{ route('guru.perkembangan.index') }}" class="btn btn-link btn-sm text-decoration-none text-primary fw-bold">Lihat Semua Aktivitas</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Monthly Trends Chart -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Tren Perkembangan Bulanan</h6>
                </div>
                <div class="card-body">
                    <div style="height: 250px;">
                        <canvas id="chart-bulanan"></canvas>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Total Data 6 Bulan Terakhir</div>
                            <h5 class="fw-bold mb-0 text-dark">{{ array_sum($chartBulanan['data'] ?? []) }} Catatan</h5>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i> Terhubung PHPMyAdmin
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    :root {
        --bs-soft-primary: #f0f4ff;
        --bs-soft-success: #f0fff4;
        --bs-soft-warning: #fffcf0;
        --bs-soft-info: #f0fbff;
        --bs-soft-danger: #fff5f5;
    }
    .bg-soft-primary { background-color: var(--bs-soft-primary); }
    .bg-soft-success { background-color: var(--bs-soft-success); }
    .bg-soft-warning { background-color: var(--bs-soft-warning); }
    .bg-soft-info { background-color: var(--bs-soft-info); }
    .bg-soft-danger { background-color: var(--bs-soft-danger); }

    .hover-action {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-action:hover {
        background: #fff !important;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .hover-up {
        transition: all 0.3s ease;
    }
    .hover-up:hover {
        transform: translateY(-2px);
    }
    .btn-white {
        background: #fff;
        color: #4361ee;
        border: none;
    }
    .btn-outline-white {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.5);
    }
    .btn-outline-white:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
        border-color: #fff;
    }
    .icon-shape {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-stat {
        transition: all 0.3s ease;
    }
    .card-stat:hover {
        transform: scale(1.02);
    }
    .pulse {
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        const statsElement = document.getElementById('dashboard-stats');
        if (!statsElement) return;

        const aspekLabels = JSON.parse(statsElement.dataset.aspekLabels || '[]');
        const aspekData = JSON.parse(statsElement.dataset.aspekValues || '[]');
        const aspekColors = JSON.parse(statsElement.dataset.aspekColors || '[]');
        const bulanLabels = JSON.parse(statsElement.dataset.bulanLabels || '[]');
        const bulanData = JSON.parse(statsElement.dataset.bulanValues || '[]');

        if (aspekLabels.length && document.getElementById('chart-aspek')) {
            new Chart(document.getElementById('chart-aspek'), {
                type: 'bar',
                data: {
                    labels: aspekLabels,
                    datasets: [{
                        label: 'Jumlah Capaian',
                        data: aspekData,
                        backgroundColor: aspekColors.map(c => c + 'cc'),
                        hoverBackgroundColor: aspekColors,
                        borderRadius: 12,
                        borderWidth: 0,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            precision: 0,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#4b5563', font: { size: 11, weight: '600' } }
                        }
                    }
                }
            });
        }

        if (bulanLabels.length && document.getElementById('chart-bulanan')) {
            new Chart(document.getElementById('chart-bulanan'), {
                type: 'line',
                data: {
                    labels: bulanLabels,
                    datasets: [{
                        label: 'Total Aktivitas',
                        data: bulanData,
                        fill: true,
                        borderColor: '#2ec4b6',
                        backgroundColor: 'rgba(46, 196, 182, 0.05)',
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2ec4b6',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            precision: 0,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#4b5563', font: { size: 11 } }
                        }
                    }
                }
            });
        }
    })();
</script>
@endpush

