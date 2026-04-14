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

