@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center">
            <a href="{{ route('guru.kelas.index') }}" class="btn btn-link text-muted text-decoration-none p-0 me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="mb-0">Edit Kelas</h3>
                <p class="text-muted small mb-0">Perbarui informasi kelas.</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('guru.kelas.update', ['kelas' => $kelasId]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" 
                                   value="{{ old('nama_kelas', $kelas->nama_kelas) }}" placeholder="Contoh: Kelas A" required>
                            @error('nama_kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Kode Kelas</label>
                            <input type="text" name="kode_kelas" class="form-control @error('kode_kelas') is-invalid @enderror" 
                                   value="{{ old('kode_kelas', $kelas->kode_kelas) }}" placeholder="Contoh: KEL-A" required>
                            @error('kode_kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Tingkat</label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="A" {{ old('tingkat', $kelas->tingkat) == 'A' ? 'selected' : '' }}>Tingkat A</option>
                                <option value="B" {{ old('tingkat', $kelas->tingkat) == 'B' ? 'selected' : '' }}>Tingkat B</option>
                                <option value="B1" {{ old('tingkat', $kelas->tingkat) == 'B1' ? 'selected' : '' }}>Tingkat B1</option>
                            </select>
                            @error('tingkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control @error('wali_kelas') is-invalid @enderror" 
                                   value="{{ old('wali_kelas', $kelas->wali_kelas) }}" placeholder="Nama wali kelas">
                            @error('wali_kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $kelas->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $kelas->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" 
                                      placeholder="Deskripsi singkat tentang kelas ini...">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('guru.kelas.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
