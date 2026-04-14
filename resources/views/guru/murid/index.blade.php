@extends('layouts.app')

@section('title', 'Data Murid')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h3 class="mb-0">Data Murid</h3>
            <div class="text-muted">Kelola data murid di sekolah.</div>
        </div>
        <a class="btn btn-primary" href="{{ route('guru.murid.create') }}">
            <i class="bi bi-person-plus me-2"></i>Tambah Murid
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="fw-semibold"><i class="bi bi-people me-2"></i>Daftar Murid</div>
            <div class="text-muted small">Total: {{ $murid->total() }}</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Biodata Murid</th>
                            <th>Identitas</th>
                            <th>Orang Tua & Rombel</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($murid as $m)
                            <tr>
                                <td style="width: 64px;">
                                    @if($m->foto)
                                        <img src="{{ asset('storage/'.$m->foto) }}" alt="Foto {{ $m->nama_lengkap }}" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-person text-secondary fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">
                                        <a class="text-decoration-none text-dark" href="{{ route('guru.murid.show', $m) }}">
                                            {{ $m->nama_lengkap }}
                                        </a>
                                    </div>
                                    <div class="small text-muted">
                                        <span class="badge text-bg-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $m->jenis_kelamin == 'L' ? 'primary' : 'danger' }} border-0" style="font-size: 0.7rem;">
                                            {{ $m->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                        <span class="ms-1">{{ $m->tanggal_lahir?->format('d M Y') ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="small mb-1"><strong>NIK:</strong> {{ $m->nik ?? '-' }}</div>
                                    <div class="small"><strong>NISN:</strong> {{ $m->nisn ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="small mb-1"><i class="bi bi-person-heart me-1 text-muted"></i>{{ $m->nama_orang_tua ?? '-' }}</div>
                                    <div class="small"><span class="badge bg-info bg-opacity-10 text-info border-0">{{ $m->rombel ?? 'Belum ada rombel' }}</span></div>
                                </td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('guru.murid.edit', $m) }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form class="d-inline" method="POST" action="{{ route('guru.murid.destroy', $m) }}"
                                          onsubmit="return confirm('Hapus murid ini?');">
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
                                    Belum ada data murid.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($murid->hasPages())
            <div class="card-body">
                {{ $murid->links() }}
            </div>
        @endif
    </div>
@endsection

