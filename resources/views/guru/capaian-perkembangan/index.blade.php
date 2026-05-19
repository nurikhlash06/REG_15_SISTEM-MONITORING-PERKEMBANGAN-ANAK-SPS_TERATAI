@extends('layouts.app')

@section('title', 'Capaian Perkembangan')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-0">Capaian Perkembangan</h3>
            <div class="text-muted">Lihat capaian perkembangan anak satu per satu.</div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('guru.capaian-perkembangan.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama murid..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="bulan" class="form-select">
                            @foreach($listBulan as $num => $nama)
                                <option value="{{ $num }}" {{ $bulan === $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun" class="form-select">
                            @foreach($listTahun as $th)
                                <option value="{{ $th }}" {{ $tahun === $th ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="fw-semibold"><i class="bi bi-people me-2"></i>Daftar Murid</div>
            <div class="text-muted small">Total: {{ $muridList->total() }}</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Murid</th>
                            <th>Kelas</th>
                            <th>Capaian</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($muridList as $murid)
                            @php
                                $capaian = $capaianPerMurid[$murid->id] ?? null;
                            @endphp
                            <tr>
                                <td style="width: 64px;">
                                    @php
                                        $fotoPath = $murid->foto ? (str_starts_with($murid->foto, 'http') ? $murid->foto : asset('storage/' . $murid->foto)) : null;
                                    @endphp
                                    @if($fotoPath)
                                        <img src="{{ $fotoPath }}" alt="Foto {{ $murid->nama_lengkap }}" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 50px; height: 50px; border: 1px dashed #ddd;">
                                            <img src="{{ asset('images/logo-paud.png') }}" alt="Logo" style="width: 35px; height: 35px; object-fit: contain; opacity: 0.7;">
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $murid->nama_lengkap }}</div>
                                    <div class="small text-muted">
                                        <span class="badge text-bg-{{ $murid->jenis_kelamin == 'L' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $murid->jenis_kelamin == 'L' ? 'primary' : 'danger' }} border-0" style="font-size: 0.7rem;">
                                            {{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($murid->kelas)
                                        <span class="badge bg-soft-purple text-purple border-0">{{ $murid->kelas->nama_kelas }}</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border-0">Belum ada kelas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($capaian)
                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $capaian['hitung']['total_persentase'] }}%; background-color: {{ $capaian['status_warna']['color'] }};" aria-valuenow="{{ $capaian['hitung']['total_persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-semibold small" style="color: {{ $capaian['status_warna']['color'] }};">
                                                    {{ $capaian['hitung']['total_persentase'] }}%
                                                </span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($capaian['hitung']['nilai_bagian'] as $bagian => $nilai)
                                                    @if($nilai['kode'])
                                                        <span class="badge rounded-pill px-2 py-1" style="background-color: {{ $skorLabels[$nilai['kode']]['color'] }}20; color: {{ $skorLabels[$nilai['kode']]['color'] }}; font-size: 0.7rem;">
                                                            {{ $skorLabels[$nilai['kode']]['short'] }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">Belum ada capaian</span>
                                    @endif
                                </td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-primary btn-sm" href="{{ route('guru.capaian-perkembangan.show', ['id' => $murid->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}">
                                        <i class="bi bi-eye me-1"></i> Lihat Capaian
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="mb-2"><i class="bi bi-people fs-1 opacity-25"></i></div>
                                    @if(request('search') || request('kelas_id'))
                                        Tidak ditemukan murid dengan kriteria tersebut.
                                    @else
                                        Belum ada data murid.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($muridList->hasPages())
            <div class="card-body">
                {{ $muridList->links() }}
            </div>
        @endif
    </div>
@endsection
