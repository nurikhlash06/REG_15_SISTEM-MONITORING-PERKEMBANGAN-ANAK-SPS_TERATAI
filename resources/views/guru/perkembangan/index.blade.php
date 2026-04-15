@extends('layouts.app')

@section('title', 'Perkembangan Anak')

@section('content')
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
        <div class="card border-0 shadow-lg mb-4" style="border-radius: 24px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);">
                        <div class="p-4 text-white text-center h-100 d-flex flex-column justify-content-center align-items-center">
                            <div class="position-relative mb-3">
                                @if(!empty($selectedMurid->foto))
                                    <img src="{{ asset('storage/'.$selectedMurid->foto) }}" alt="Foto" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid rgba(255,255,255,0.2);">
                                @else
                                    <div class="rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px; border: 4px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-person text-white fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <h4 class="fw-bold mb-1">{{ $selectedMurid->nama_lengkap }}</h4>
                            <p class="text-white text-opacity-75 mb-3"><small>{{ $selectedMurid->kelas->nama_kelas ?? 'Belum ada kelas' }}</small></p>
                            <div class="mt-auto d-flex gap-2 flex-wrap justify-content-center">
                                <a href="{{ route('guru.perkembangan.create', ['murid_id' => $selectedMurid->id]) }}" class="btn btn-sm btn-light text-primary fw-bold px-3 rounded-pill">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Catatan
                                </a>
                                <a href="{{ route('guru.murid.show', $selectedMurid->id) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> Profil
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8" style="background: #f8fafc;">
                        <div class="p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-info-circle text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">Informasi Murid</h5>
                                    <p class="text-muted mb-0 small">Data identitas dan kelas</p>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="text-muted small mb-1">NIK</div>
                                        <div class="fw-semibold text-dark">{{ $selectedMurid->nik ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="text-muted small mb-1">NISN</div>
                                        <div class="fw-semibold text-dark">{{ $selectedMurid->nisn ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="text-muted small mb-1">Jenis Kelamin</div>
                                        <div class="fw-semibold text-dark">{{ $selectedMurid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-white rounded-4 border h-100">
                                        <div class="text-muted small mb-1">Orang Tua</div>
                                        <div class="fw-semibold text-dark small">{{ $selectedMurid->nama_orang_tua ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-grid-fill me-2 text-primary"></i>Status Capaian Semua Aspek</h5>
                    <p class="text-muted mb-0 small">Catatan perkembangan terbaru untuk setiap kategori.</p>
                </div>
                <div class="badge bg-primary bg-opacity-10 text-primary border-0 rounded-pill px-3 py-2">
                    {{ now()->translatedFormat('F Y') }}
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($aspekSummary as $aspek)
                @php 
                    $styles = $aspek->styles;
                    $aspekClass = match(true) {
                        str_contains($aspek->name, 'Agama') => 'aspek-agama',
                        str_contains($aspek->name, 'Fisik') => 'aspek-fisik',
                        str_contains($aspek->name, 'Kognitif') => 'aspek-kognitif',
                        str_contains($aspek->name, 'Bahasa') => 'aspek-bahasa',
                        str_contains($aspek->name, 'Sosial') => 'aspek-sosial',
                        str_contains($aspek->name, 'Seni') => 'aspek-seni',
                        default => ''
                    };
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm {{ $aspekClass }}" style="border-radius: 20px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="aspek-icon-box bg-aspek text-aspek" style="width: 44px; height: 44px;">
                                        <i class="bi {{ $styles['icon'] }}"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $aspek->name }}</h6>
                                </div>
                                @if($aspek->skor > 0)
                                    <span class="badge rounded-pill border-0 px-3 py-1 fw-bold badge-aspek" style="font-size: 0.75rem;">
                                        {{ $aspek->skor }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($aspek->catatan)
                                <div class="p-3 rounded-4 mb-3 bg-aspek" style="min-height: 80px;">
                                    <p class="mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.5;">{{ Str::limit($aspek->catatan, 120) }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between" style="font-size: 0.75rem;">
                                    <span class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $aspek->tanggal?->format('d M Y') }}</span>
                                    <a href="{{ route('guru.perkembangan.index', ['murid_id' => $selectedMurid->id, 'aspek' => $aspek->name]) }}" class="text-primary text-decoration-none fw-semibold">
                                        Riwayat <i class="bi bi-arrow-right small ms-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="p-4 rounded-4 text-center mb-2" style="background-color: rgba(0,0,0,0.03); border: 2px dashed rgba(0,0,0,0.1);">
                                    <i class="bi bi-journal-x text-muted fs-4 mb-2 d-block"></i>
                                    <span class="text-muted small">Belum ada catatan</span>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('guru.perkembangan.create', ['murid_id' => $selectedMurid->id, 'aspek' => $aspek->name]) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold px-3">
                                        <i class="bi bi-plus-circle me-1"></i> Input Sekarang
                                    </a>
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
                                <td class="fw-semibold">{{ $p->aspek }}</td>
                                <td class="text-truncate" style="max-width: 420px;">{{ $p->catatan }}</td>
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

