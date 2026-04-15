@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">Data Kelas</h3>
                <p class="text-muted small mb-0">Kelola kelas dan distribusikan murid.</p>
            </div>
            <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Tambah Kelas
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm small rounded-3 py-3">
    <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
</div>
@endif

<div class="row g-4">
    @forelse($kelas as $k)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-white">
                        <span class="badge bg-white text-primary rounded-pill mb-1" style="font-size: 0.65rem;">Kelas {{ $k->tingkat }}</span>
                        <h5 class="mb-0 fw-bold" style="word-wrap: break-word; font-size: 1rem; line-height: 1.2;">{{ $k->nama_kelas }}</h5>
                        <small class="opacity-75" style="font-size: 0.7rem;">{{ $k->kode_kelas }}</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li><a class="dropdown-item" href="{{ route('guru.kelas.edit', ['kelas' => $k->id]) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('guru.kelas.destroy', ['kelas' => $k->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-5">
                        <div class="text-center p-3 rounded-4 h-100 d-flex flex-column justify-content-center" style="background: #f0f4ff; min-height: 90px;">
                            <div class="fw-bold text-primary fs-4">{{ $k->murids_count }}</div>
                            <small class="text-muted">Total Murid</small>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="text-center p-3 rounded-4 h-100 d-flex flex-column justify-content-center" style="background: #f0fff4; min-height: 90px;">
                            <div class="fw-bold text-success" style="word-wrap: break-word; line-height: 1.3; font-size: 0.95rem;">{{ $k->wali_kelas ?? '-' }}</div>
                            <small class="text-muted mt-auto">Wali Kelas</small>
                        </div>
                    </div>
                </div>
                
                @if($k->deskripsi)
                <p class="small text-muted mt-3 mb-0">{{ Str::limit($k->deskripsi, 80) }}</p>
                @endif
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="badge {{ $k->status === 'aktif' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $k->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <a href="{{ route('guru.murid.index', ['kelas' => $k->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="bi bi-people me-1"></i>Lihat Murid
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="bi bi-grid-3x3-gap-fill fs-1 text-muted opacity-25"></i>
            <p class="text-muted mt-3">Belum ada data kelas.</p>
            <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary btn-sm rounded-pill">
                <i class="bi bi-plus-lg me-1"></i>Tambah Kelas Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection
