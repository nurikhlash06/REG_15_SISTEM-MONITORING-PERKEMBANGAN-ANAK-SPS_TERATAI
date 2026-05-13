@extends('layouts.app')

@section('title', 'Edit Orang Tua')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Edit Akun Orang Tua</h4>
            <p class="text-muted small">Perbarui data akun atau ganti password wali murid.</p>
        </div>
        <a href="{{ route('guru.orangtua.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('guru.orangtua.update', $orangtua->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small">Nama Lengkap Orang Tua</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" value="{{ old('name', $orangtua->name) }}"
                                   class="form-control bg-light border-0 @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap..." required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small">Email / Username Login</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" value="{{ old('email', $orangtua->email) }}"
                                   class="form-control bg-light border-0 @error('email') is-invalid @enderror" 
                                   placeholder="contoh@email.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small">Ganti Password (Opsional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="password"
                                   class="form-control bg-light border-0 @error('password') is-invalid @enderror" 
                                   placeholder="Kosongkan jika tidak ingin mengganti...">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-text small text-muted mt-1">Isi hanya jika ingin mengganti password login orang tua.</div>
                    </div>

                    <div class="d-grid pt-2">
                        <button class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm" type="submit">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-text { border-radius: 12px 0 0 12px !important; }
    .form-control { border-radius: 0 12px 12px 0 !important; }
    .form-control:focus { background-color: #fff !important; box-shadow: none !important; border: 1px solid #4361ee !important; }
</style>
@endsection
