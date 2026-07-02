@extends('layouts.app')

@section('title', 'Perkembangan Anak')

@section('content')
    @if(isset($dynamicStyles))
        <style><?php echo $dynamicStyles; ?></style>
    @endif
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-0">Perkembangan Anak</h3>
            <div class="text-muted">Catatan perkembangan yang diinput oleh guru.</div>
        </div>
        <a class="btn btn-primary" href="{{ route('guru.perkembangan.create') }}">
            <i class="bi bi-plus-circle me-2"></i>Tambah Perkembangan
        </a>
    </div>

    @if($selectedMurid)
    <div class="mb-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-2 text-center">
                        @php
                            $fotoPath = $selectedMurid->foto ? (str_starts_with($selectedMurid->foto, 'http') ? $selectedMurid->foto : asset('storage/' . $selectedMurid->foto)) : null;
                        @endphp
                        @if($fotoPath)
                            <img src="{{ $fotoPath }}" alt="Foto" class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto" style="width: 80px; height: 80px; border: 2px dashed #ddd;">
                                <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" style="width: 50px; height: 50px; object-fit: contain;">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h5 class="fw-bold mb-1">{{ $selectedMurid->nama_lengkap }}</h5>
                        <p class="text-muted mb-1 small"><i class="bi bi-book me-1"></i>{{ $selectedMurid->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                        <p class="text-muted mb-0 small"><i class="bi bi-person me-1"></i>{{ $selectedMurid->nama_orang_tua ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="small text-muted">NIK</div>
                                <div class="fw-semibold">{{ $selectedMurid->nik ?? '-' }}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">NISN</div>
                                <div class="fw-semibold">{{ $selectedMurid->nisn ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            <a href="{{ route('guru.perkembangan.create', ['murid_id' => $selectedMurid->id]) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Tambah
                            </a>
                            <a href="{{ route('guru.murid.show', $selectedMurid->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye me-1"></i>Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-grid-fill me-2 text-primary"></i>Status Capaian Terbaru</h6>
        </div>

        <div class="row g-3">
            @foreach($aspekSummary as $aspek)
                @php 
                    $styles = $aspek->styles;
                    $slug = \Illuminate\Support\Str::slug($aspek->name);
                @endphp
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm aspek-card-<?php echo $slug; ?>" style="border-radius: 16px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="aspek-icon-box aspect-icon-<?php echo $slug; ?>" style="width: 32px; height: 32px;">
                                        <i class="bi {{ $styles['icon'] }}" style="font-size: 1rem;"></i>
                                    </div>
                                    <span class="fw-bold text-dark small">{{ $aspek->name }}</span>
                                </div>
                                @if($aspek->skor > 0 && isset($skorLabels[$aspek->skor]))
                                    <span class="badge rounded-pill border-0 px-2 py-1 fw-bold" style="font-size: 0.7rem; background-color: <?php echo $skorLabels[$aspek->skor]['color']; ?>20; color: <?php echo $skorLabels[$aspek->skor]['color']; ?>; border: 1px solid <?php echo $skorLabels[$aspek->skor]['color']; ?>40;">
                                        {{ $skorLabels[$aspek->skor]['short'] }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($aspek->catatan)
                                <div class="p-2 rounded-3 mb-2 bg-aspek" style="font-size: 0.75rem; line-height: 1.4;">
                                    {{ Str::limit($aspek->catatan, 80) }}
                                </div>
                                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.7rem;">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $aspek->tanggal?->format('d M Y') }}</span>
                                </div>
                            @else
                                <div class="text-center text-muted py-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-journal-x me-1"></i>Belum ada catatan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('guru.perkembangan.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Cari Nama Murid</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" 
                                   placeholder="Masukkan nama murid..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Murid</label>
                        <select name="murid_id" class="form-select">
                            <option value="">Semua Murid</option>
                            @foreach($murid as $m)
                                <option value="{{ $m->id }}" @selected(request('murid_id') == $m->id)>
                                    {{ $m->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Filter Aspek</label>
                        <select name="aspek" class="form-select">
                            <option value="">Semua Aspek</option>
                            @foreach($aspekOptions as $opt)
                                <option value="{{ $opt }}" @selected(request('aspek') == $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            @if(request()->anyFilled(['search', 'murid_id', 'aspek']))
                                <a href="{{ route('guru.perkembangan.index') }}" class="btn btn-outline-secondary" title="Reset">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="fw-semibold"><i class="bi bi-graph-up me-2"></i>Daftar Perkembangan</div>
            <div class="text-muted small">Total: {{ $perkembangan->total() }}</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Tanggal</th>
                            <th>Murid</th>
                            <th>Aspek</th>
                            <th>Capaian</th>
                            <th>Catatan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perkembangan as $p)
                            <tr>
                                <td class="text-nowrap">{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                                <td class="fw-semibold">
                                    @if($p->murid)
                                        <a class="text-decoration-none" href="{{ route('guru.murid.show', $p->murid) }}">
                                            {{ $p->murid->nama_lengkap }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="fw-semibold small">{{ $p->aspek }}</td>
                                <td>
                                    @if($p->skor && isset($skorLabels[$p->skor]))
                                        <span class="badge rounded-pill px-3" style="background-color: <?php echo $skorLabels[$p->skor]['color']; ?>20; color: <?php echo $skorLabels[$p->skor]['color']; ?>; border: 1px solid <?php echo $skorLabels[$p->skor]['color']; ?>40; font-size: 0.75rem;">
                                            {{ $skorLabels[$p->skor]['short'] }}
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
                                    <form class="d-inline" method="POST" action="{{ route('guru.perkembangan.destroy', $p) }}"
                                          onsubmit="return confirm('Hapus catatan perkembangan ini?');">
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
                                    Belum ada catatan perkembangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($perkembangan->hasPages())
            <div class="card-body">
                {{ $perkembangan->links() }}
            </div>
        @endif
    </div>
@endsection

