@extends('layouts.parent_mobile')

@section('title', 'Perkembangan Anak')

@section('content')
    @if(isset($dynamicStyles))
        <style><?php echo $dynamicStyles; ?></style>
    @endif
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Catatan Perkembangan 📚</h4>
        <p class="text-muted small">Lihat riwayat perkembangan anak Anda.</p>
    </div>

    <!-- Filter Card (Mobile Friendly) -->
    <div class="card card-mobile mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('orangtua.perkembangan.index') }}">
                <div class="row g-2">
                    <div class="col-6">
                        <select name="murid_id" class="form-select form-select-sm rounded-3 border-0 bg-light">
                            <option value="">Semua Anak</option>
                            @foreach($murid as $m)
                                <option value="{{ $m->id }}" @selected((string) $selectedMuridId === (string) $m->id)>
                                    {{ $m->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="aspek" class="form-select form-select-sm rounded-3 border-0 bg-light">
                            <option value="">Semua Aspek</option>
                            @php
                                $aspekOptions = ['Nilai Agama/Moral', 'Fisik-Motorik', 'Kognitif', 'Bahasa', 'Sosial-Emosional', 'Seni'];
                            @endphp
                            @foreach($aspekOptions as $opt)
                                <option value="{{ $opt }}" @selected($selectedAspek === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-sm btn-gradient w-100 py-2" type="submit">
                            <i class="bi bi-funnel me-1"></i> Filter Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- List of Development Notes -->
    <div class="d-flex flex-column gap-3">
        @forelse($perkembangan as $p)
            @php 
                $slug = \Illuminate\Support\Str::slug($p->aspek);
            @endphp
            <div class="card card-mobile p-3 border-start border-4 aspek-card-<?php echo $slug; ?> border-aspek">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-light text-dark border small mb-1">{{ $p->tanggal?->format('d M Y') ?? '-' }}</span>
                        <h6 class="fw-bold mb-0" style="color: <?php echo $colorMap[$p->aspek]['text'] ?? '#334155'; ?>;">{{ $p->aspek }}</h6>
                        
                        @if($p->skor && isset($skorLabels[$p->skor]))
                            <span class="badge rounded-pill small mt-1" style="font-size: 0.65rem; background-color: <?php echo $skorLabels[$p->skor]['color']; ?>15; color: <?php echo $skorLabels[$p->skor]['color']; ?>; border: 1px solid <?php echo $skorLabels[$p->skor]['color']; ?>30;">
                                {{ $skorLabels[$p->skor]['short'] }}
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('orangtua.perkembangan.show', $p) }}" class="btn btn-sm btn-light rounded-pill px-3">
                        Detail <i class="bi bi-chevron-right ms-1 small"></i>
                    </a>
                </div>
                
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                        <i class="bi bi-person text-muted" style="font-size: 0.8rem;"></i>
                    </div>
                    <span class="text-muted small fw-semibold">{{ $p->murid?->nama_lengkap ?? '-' }}</span>
                </div>

                <p class="text-muted small mb-0 text-truncate-2">
                    {{ str($p->catatan)->limit(100) }}
                </p>
            </div>
        @empty
            <div class="card card-mobile p-5 text-center">
                <div class="mb-3">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                </div>
                <h6 class="fw-bold">Belum Ada Catatan</h6>
                <p class="text-muted small mb-0">Catatan perkembangan akan muncul setelah diinput oleh guru.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination (Mobile Friendly) -->
    @if($perkembangan->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $perkembangan->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <style>
        .text-primary-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection