@extends('layouts.app')

@section('title', 'Data Orang Tua')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Daftar Akun Orang Tua</h4>
            <p class="text-muted small">Kelola akses wali murid ke sistem.</p>
        </div>
        <a href="{{ route('guru.orangtua.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Orang Tua
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Nama Orang Tua</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Email / Username</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase text-center">Jumlah Anak</th>
                        <th class="pe-4 py-3 border-0 text-muted small fw-bold text-uppercase text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orangtua as $ortu)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                    {{ substr($ortu->name, 0, 1) }}
                                </div>
                                <span class="fw-bold text-dark">{{ $ortu->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark">{{ $ortu->email }}</div>
                            <small class="text-muted">Dibuat: {{ $ortu->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-soft-success text-success rounded-pill px-3 py-2">
                                {{ $ortu->murid_count }} Anak
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <form action="{{ route('guru.orangtua.destroy', $ortu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akun orang tua ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-soft-danger btn-sm rounded-pill px-3 border-0 shadow-none">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="opacity-25 mb-2">
                                <i class="bi bi-people-fill fs-1"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada akun orang tua terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(67, 97, 238, 0.1) !important; }
    .bg-soft-success { background-color: rgba(0, 184, 148, 0.1) !important; }
    .btn-soft-danger { 
        background-color: rgba(214, 48, 49, 0.1) !important; 
        color: #d63031 !important;
    }
    .btn-soft-danger:hover {
        background-color: #d63031 !important;
        color: #fff !important;
    }
</style>
@endsection
