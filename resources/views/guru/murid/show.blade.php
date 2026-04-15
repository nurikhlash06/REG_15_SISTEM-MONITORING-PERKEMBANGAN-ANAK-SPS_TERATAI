@extends('layouts.app')

@section('title', 'Detail Murid')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-0">{{ $murid->nama_lengkap }}</h3>
            <div class="text-muted">Profil lengkap dan ringkasan perkembangan.</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('guru.murid.edit', $murid) }}">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <a class="btn btn-outline-secondary" href="{{ route('guru.murid.index') }}">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <div class="fw-semibold"><i class="bi bi-person me-2"></i>Profil Murid</div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @php
                            $fotoPath = $murid->foto ? (str_starts_with($murid->foto, 'http') ? $murid->foto : asset('storage/' . $murid->foto)) : null;
                        @endphp
                        @if($fotoPath)
                            <img src="{{ $fotoPath }}" alt="Foto {{ $murid->nama_lengkap }}" class="rounded-circle me-3 shadow-sm" style="width: 85px; height: 85px; object-fit: cover; border: 4px solid white;">
                        @else
                            <div class="d-flex align-items-center justify-content-center me-3 bg-light rounded-circle shadow-sm" style="width: 85px; height: 85px; border: 2px dashed #ddd;">
                                <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" style="width: 60px; height: 60px; object-fit: contain; opacity: 0.8;">
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold">{{ $murid->nama_lengkap }}</div>
                            <div class="text-muted small">ID: {{ $murid->id }}</div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-5 text-muted small">Jenis Kelamin</div>
                        <div class="col-7 fw-semibold small">{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>

                        <div class="col-5 text-muted small">Tanggal Lahir</div>
                        <div class="col-7 fw-semibold small">{{ $murid->tanggal_lahir?->format('d M Y') ?? '-' }}</div>

                        <div class="col-5 text-muted small">NIK</div>
                        <div class="col-7 fw-semibold small">{{ $murid->nik ?? '-' }}</div>

                        <div class="col-5 text-muted small">NISN</div>
                        <div class="col-7 fw-semibold small">{{ $murid->nisn ?? '-' }}</div>

                        <div class="col-5 text-muted small">Berat Badan</div>
                        <div class="col-7 fw-semibold small">{{ $murid->berat_badan ? $murid->berat_badan . ' kg' : '-' }}</div>

                        <div class="col-5 text-muted small">Tinggi Badan</div>
                        <div class="col-7 fw-semibold small">{{ $murid->tinggi_badan ? $murid->tinggi_badan . ' cm' : '-' }}</div>

                        <div class="col-5 text-muted small">Lingkar Kepala</div>
                        <div class="col-7 fw-semibold small">{{ $murid->lingkar_kepala ? $murid->lingkar_kepala . ' cm' : '-' }}</div>

                        <div class="col-5 text-muted small">Kelas</div>
                        <div class="col-7 fw-semibold small">
                            @if($murid->kelas)
                                <span class="badge bg-primary bg-opacity-10 text-primary border-0">{{ $murid->kelas->nama_kelas }}</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border-0">-</span>
                            @endif
                        </div>

                        <div class="col-5 text-muted small">Orang Tua</div>
                        <div class="col-7 fw-semibold small">{{ $murid->nama_orang_tua ?? '-' }}</div>

                        <div class="col-5 text-muted small">Email Orang Tua</div>
                        <div class="col-7 fw-semibold small">{{ $murid->email_orang_tua ?? '-' }}</div>

                        <div class="col-5 text-muted small">Alamat</div>
                        <div class="col-7 fw-semibold small text-wrap">{{ $murid->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;"><i class="bi bi-grid-fill me-2 text-primary"></i>Status Capaian Semua Aspek</h5>
                            <p class="text-muted mb-0 small">Ringkasan perkembangan terbaru</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border-0 rounded-pill px-3 py-2">
                            {{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
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
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm {{ $aspekClass }}" style="border-radius: 16px;">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="aspek-icon-box bg-aspek text-aspek">
                                                    <i class="bi {{ $styles['icon'] }}" style="font-size: 0.9rem;"></i>
                                                </div>
                                                <span class="fw-bold text-dark" style="font-size: 0.75rem;">{{ $aspek->name }}</span>
                                            </div>
                                            @if($aspek->skor > 0)
                                                <span class="badge rounded-pill border-0 px-2 py-1 fw-bold badge-aspek" style="font-size: 0.7rem;">
                                                    {{ $aspek->skor }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($aspek->catatan)
                                            <div class="p-2 rounded-3 mb-1 bg-aspek">
                                                <p class="text-dark mb-0" style="font-size: 0.7rem; line-height: 1.4;">{{ Str::limit($aspek->catatan, 80) }}</p>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.65rem;"><i class="bi bi-calendar3 me-1"></i>{{ $aspek->tanggal?->format('d M Y') }}</span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.7rem;">Belum ada catatan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="fw-semibold"><i class="bi bi-graph-up me-2"></i>Riwayat Perkembangan</div>
                    <a class="btn btn-primary btn-sm" href="{{ route('guru.perkembangan.create', ['murid_id' => $murid->id]) }}">
                        <i class="bi bi-plus-circle me-2"></i>Tambah
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Tanggal</th>
                                    <th>Aspek</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($murid->perkembangan->take(10) as $p)
                                    <tr>
                                        <td class="text-nowrap">{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                                        <td class="fw-semibold">{{ $p->aspek }}</td>
                                        <td class="text-truncate" style="max-width: 380px;">{{ $p->catatan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Belum ada catatan perkembangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

