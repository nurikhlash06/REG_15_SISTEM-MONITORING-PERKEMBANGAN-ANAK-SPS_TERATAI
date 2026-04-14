@extends('layouts.app')

@section('title', 'Detail Murid')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-0">{{ $murid->nama_lengkap }}</h3>
            <div class="text-muted">Detail data murid dan perkembangan terakhir.</div>
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
                        @if($murid->foto)
                            <img src="{{ asset('storage/'.$murid->foto) }}" alt="Foto {{ $murid->nama_lengkap }}" class="rounded-circle me-3" style="width: 72px; height: 72px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center me-3" style="width: 72px; height: 72px;">
                                <i class="bi bi-person text-secondary fs-3"></i>
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

                        <div class="col-5 text-muted small">Rombel / Kelas</div>
                        <div class="col-7 fw-semibold small">
                            <span class="badge bg-info bg-opacity-10 text-info border-0">{{ $murid->rombel ?? '-' }}</span>
                        </div>

                        <div class="col-5 text-muted small">Orang Tua</div>
                        <div class="col-7 fw-semibold small">{{ $murid->nama_orang_tua ?? '-' }}</div>

                        <div class="col-5 text-muted small">Alamat</div>
                        <div class="col-7 fw-semibold small text-wrap">{{ $murid->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="fw-semibold"><i class="bi bi-graph-up me-2"></i>Perkembangan Terbaru</div>
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

