@extends('layouts.parent_mobile')

@section('title', 'Detail Perkembangan')

@section('content')
    @if(isset($dynamicStyles))
        <style><?php echo $dynamicStyles; ?></style>
    @endif
    <div class="mb-4 d-flex align-items-center gap-3">
        <a href="{{ route('orangtua.perkembangan.index') }}" class="btn btn-sm btn-light rounded-circle p-2 shadow-sm">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <h4 class="fw-bold mb-0">Detail Catatan 📝</h4>
    </div>

    <!-- Main Detail Card -->
    <div class="card card-mobile mb-4">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <div class="badge bg-light text-primary-gradient border px-3 py-2 rounded-pill mb-2">
                    {{ $perkembangan->tanggal?->format('d F Y') ?? '-' }}
                </div>
                <h4 class="fw-bold mb-1">{{ $perkembangan->aspek }}</h4>
                <p class="text-muted small">Catatan untuk {{ $perkembangan->murid?->nama_lengkap ?? '-' }}</p>
                
                @if($perkembangan->skor && isset($skorLabels[$perkembangan->skor]))
                    <div class="mb-3">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: <?php echo $skorLabels[$perkembangan->skor]['color']; ?>20; color: <?php echo $skorLabels[$perkembangan->skor]['color']; ?>; border: 1px solid <?php echo $skorLabels[$perkembangan->skor]['color']; ?>40;">
                            {{ $skorLabels[$perkembangan->skor]['short'] }} - {{ $skorLabels[$perkembangan->skor]['full'] }}
                        </span>
                    </div>
                @endif

                <div class="d-flex justify-content-center mt-2">
                    @php 
                        $slug = \Illuminate\Support\Str::slug($perkembangan->aspek);
                        $styles = $colorMap[$perkembangan->aspek] ?? null;
                    @endphp
                    <div class="aspek-icon-box aspect-icon-<?php echo $slug; ?>" 
                         style="width: 50px; height: 50px;">
                        <i class="bi {{ $styles['icon'] ?? 'bi-pencil' }} fs-4"></i>
                    </div>
                </div>
            </div>

            <div class="bg-light rounded-4 p-3 mb-4">
                <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.6;">
                    {{ $perkembangan->catatan }}
                </p>
            </div>

            <hr class="opacity-10">

            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar-small">
                        {{ substr($perkembangan->guruUser?->name ?? 'G', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Dicatat oleh</p>
                        <p class="fw-bold small mb-0">{{ $perkembangan->guruUser?->name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-primary-gradient {
            background: var(--primary-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        .user-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.75rem;
            color: #666;
        }
    </style>
@endsection