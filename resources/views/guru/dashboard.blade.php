@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    @if(isset($dynamicStyles))
        <style>{{ $dynamicStyles }}</style>
    @endif
    
    <!-- Header Greeting -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 text-white position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-9">
                        <h3 class="fw-bold mb-2">{{ $greeting }}, {{ $user->name }}! 👋</h3>
                        <p class="opacity-90 mb-3 small">Selamat datang di Sistem Penilaian Perkembangan Anak. Berikut ringkasan kegiatan hari ini.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('guru.perkembangan.create') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-plus-circle me-2"></i>Input Capaian Baru
                            </a>
                            <a href="{{ route('guru.capaian-perkembangan.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-graph-up-arrow me-2"></i>Capaian Perkembangan
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block text-center">
                        <i class="bi bi-mortarboard-fill" style="font-size: 5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4" id="dashboard-stats"
         data-aspek-labels="{{ json_encode($chartAspek['labels'] ?? []) }}"
         data-aspek-values="{{ json_encode($chartAspek['data'] ?? []) }}"
         data-aspek-colors="{{ json_encode(collect($chartAspek['labels'])->map(fn($label) => $bagianPenilaian[$label]['color'] ?? '#4361ee')) }}"
         data-bulan-labels="{{ json_encode($chartBulanan['labels'] ?? []) }}"
         data-bulan-values="{{ json_encode($chartBulanan['data'] ?? []) }}">
        
        <!-- Total Murid -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-people-fill text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">{{ $stats['total_murid'] }}</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem;">Total Murid</p>
                </div>
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-house-door-fill text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">{{ $stats['total_kelas'] }}</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem;">Total Rombel</p>
                </div>
            </div>
        </div>

        <!-- Catatan Bulan Ini -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-journal-text text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">{{ $stats['total_perkembangan'] }}</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem;">Catatan Bulan Ini</p>
                </div>
            </div>
        </div>

        <!-- Update Bulan Ini -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <p class="text-muted fw-bold mb-0" style="font-size: 0.8rem;">Update Bulan Ini</p>
                        <span class="badge bg-info text-white rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.75rem;">{{ $stats['progress_bulan_ini']['percentage'] }}%</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-2" style="font-size: 1.1rem;">{{ $stats['progress_bulan_ini']['count'] }} <small class="text-muted fw-normal">/ {{ $stats['total_murid'] }} Murid</small></h4>
                    <div class="progress" style="height: 8px; border-radius: 10px; background-color: #f1f5f9;">
                        @php 
                            $pctWidth = (int)($stats['progress_bulan_ini']['percentage'] ?? 0);
                            $pctStyle = "width:{$pctWidth}%";
                        @endphp
                        <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="{{ $pctStyle }}; border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Fisik -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-speedometer2 text-danger" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 0.8rem;">Rata-rata Berat Badan</p>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">{{ $stats['fisik']['avg_bb'] }} <small class="text-muted fw-normal" style="font-size: 0.75rem;">kg</small></h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Dari {{ $stats['fisik']['count_bb'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-rulers text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 0.8rem;">Rata-rata Tinggi Badan</p>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">{{ $stats['fisik']['avg_tb'] }} <small class="text-muted fw-normal" style="font-size: 0.75rem;">cm</small></h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Dari {{ $stats['fisik']['count_tb'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 rounded-3 p-3">
                        <i class="bi bi-circle-half text-info" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 0.8rem;">Rata-rata Lingkar Kepala</p>
                        <h4 class="fw-bold text-dark mb-0" style="font-size: 1.25rem;">{{ $stats['fisik']['avg_lk'] }} <small class="text-muted fw-normal" style="font-size: 0.75rem;">cm</small></h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Dari {{ $stats['fisik']['count_lk'] }} murid</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-3 mb-4">
        <!-- Statistik Aspek -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Statistik Capaian per Aspek</h5>
                        <p class="text-muted small mb-0">Jumlah capaian yang tercatat pada bulan {{ now()->translatedFormat('F') }}</p>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.75rem;">
                        <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('F Y') }}
                    </span>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 280px;">
                        <canvas id="chart-aspek"></canvas>
                    </div>
                    @if(empty($chartAspek['labels']))
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-2 text-muted opacity-50 mb-3"></i>
                            <p class="text-muted mb-0 small">Belum ada data perkembangan yang diinput bulan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Aksi Cepat</h5>
                    <p class="text-muted small mb-0">Menu navigasi untuk mempercepat pekerjaan Anda</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-2">
                        <div class="col-12">
                            <a href="{{ route('guru.murid.index') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-sm" style="border-radius: 12px; background: #e7edff;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-3 p-2" style="min-width: 48px; min-height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Daftar Murid</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Lihat semua data siswa</div>
                                    </div>
                                    <i class="bi bi-chevron-right text-primary ms-auto"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.orangtua.index') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-sm" style="border-radius: 12px; background: #fff2e0;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning text-white rounded-3 p-2" style="min-width: 48px; min-height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person-heart" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Akun Orang Tua</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Kelola akses wali murid</div>
                                    </div>
                                    <i class="bi bi-chevron-right text-warning ms-auto"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.perkembangan.index') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-sm" style="border-radius: 12px; background: #e8f5e9;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-3 p-2" style="min-width: 48px; min-height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-journal-check" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Semua Capaian</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Lihat semua catatan perkembangan</div>
                                    </div>
                                    <i class="bi bi-chevron-right text-success ms-auto"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('guru.kelas.index') }}" class="btn btn-light w-100 text-start p-3 border-0 shadow-sm" style="border-radius: 12px; background: #f3e5f5;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-purple text-white rounded-3 p-2" style="min-width: 48px; min-height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-door-open-fill" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">Data Kelas</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Kelola rombongan belajar</div>
                                    </div>
                                    <i class="bi bi-chevron-right text-purple ms-auto"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru & Tren Bulanan -->
    <div class="row g-3">
        <!-- Aktivitas Terbaru -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;"><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Terbaru</h5>
                    <p class="text-muted small mb-0">5 catatan perkembangan terakhir</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="timeline">
                        @forelse($recentActivities as $activity)
                            <div class="timeline-item mb-3 pb-3 border-bottom border-light">
                                <div class="d-flex gap-3">
                                    @php
                                        $config = $bagianPenilaian[$activity->aspek] ?? [
                                            'icon' => 'bi-pencil-square',
                                            'color' => '#64748b',
                                        ];
                                        $slug = \Illuminate\Support\Str::slug($activity->aspek);
                                    @endphp
                                    <div class="flex-shrink-0" style="width: 40px; height: 40px;">
                                        <div class="w-100 h-100 rounded-3 d-flex align-items-center justify-content-center" style="background-color: {{ $config['color'] }}20;">
                                            <i class="bi {{ $config['icon'] }}" style="font-size: 1rem; color: {{ $config['color'] }};"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $activity->nama_murid }}</h6>
                                            <span class="text-muted small" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-muted small mb-1" style="font-size: 0.75rem;">Update <strong style="color: {{ $config['color'] }};">{{ $activity->aspek }}</strong></p>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($activity->skor && isset($kodePenilaian[$activity->skor]))
                                                <span class="badge rounded-pill px-2 py-1" style="font-size: 0.65rem; background-color: {{ $kodePenilaian[$activity->skor]['color'] }}20; color: {{ $kodePenilaian[$activity->skor]['color'] }};">
                                                    {{ $kodePenilaian[$activity->skor]['short'] }} - {{ $kodePenilaian[$activity->skor]['full'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-activity fs-2 text-muted opacity-50 mb-3"></i>
                                <p class="text-muted mb-0 small">Belum ada aktivitas tercatat.</p>
                            </div>
                        @endforelse
                    </div>
                    @if($recentActivities->isNotEmpty())
                        <div class="text-center mt-1">
                            <a href="{{ route('guru.perkembangan.index') }}" class="btn btn-link btn-sm text-decoration-none text-primary fw-semibold" style="font-size: 0.8rem;">Lihat Semua Aktivitas <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tren Bulanan -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1rem;"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Tren Perkembangan Bulanan</h5>
                    <p class="text-muted small mb-0">Total catatan perkembangan dalam 6 bulan terakhir</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 220px;">
                        <canvas id="chart-bulanan"></canvas>
                    </div>
                    <div class="mt-4 p-3 d-flex align-items-center justify-content-between" style="border-radius: 12px; background: #ecfdf5;">
                        <div>
                            <div class="text-muted small fw-semibold mb-1" style="font-size: 0.75rem;">Total Data 6 Bulan Terakhir</div>
                            <h5 class="fw-bold mb-0 text-success" style="font-size: 1.1rem;">{{ array_sum($chartBulanan['data'] ?? []) }} Catatan</h5>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-success bg-opacity-20 text-success rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.75rem;">
                                <i class="bi bi-check-circle-fill me-1"></i> Terhubung
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
        --bs-soft-success: #ecfdf5;
        --bs-soft-warning: #fff8f0;
        --bs-soft-info: #f0fbff;
        --bs-soft-danger: #fef2f2;
        --bs-purple: #8b5cf6;
    }
    .bg-soft-primary { background-color: var(--bs-soft-primary) !important; }
    .bg-soft-success { background-color: var(--bs-soft-success) !important; }
    .bg-soft-warning { background-color: var(--bs-soft-warning) !important; }
    .bg-soft-info { background-color: var(--bs-soft-info) !important; }
    .bg-soft-danger { background-color: var(--bs-soft-danger) !important; }
    .text-purple { color: var(--bs-purple) !important; }

    .timeline .timeline-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
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
                            displayColors: false,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            precision: 0,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 11, weight: '500' } }
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
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
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
                            cornerRadius: 12,
                            displayColors: false,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    return '📊 ' + context.parsed.y + ' Catatan Perkembangan';
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            precision: 0,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { color: '#9ca3af', font: { size: 11, weight: '500' } }
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
