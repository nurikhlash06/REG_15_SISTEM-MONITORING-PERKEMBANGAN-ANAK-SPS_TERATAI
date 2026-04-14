@extends('layouts.app')

@section('title', 'Edit Murid')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-0">Edit Murid</h3>
            <div class="text-muted">{{ $murid->nama_lengkap }}</div>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('guru.murid.index') }}">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="fw-semibold"><i class="bi bi-pencil me-2"></i>Form Edit</div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('guru.murid.update', $murid) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('guru.murid._form', ['murid' => $murid])

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('guru.murid.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

