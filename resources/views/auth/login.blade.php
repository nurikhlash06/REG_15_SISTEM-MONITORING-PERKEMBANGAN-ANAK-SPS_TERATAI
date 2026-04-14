@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<style>
    #togglePassword:focus {
        box-shadow: none;
    }
    .input-group-text, .form-control, #togglePassword {
        border-color: transparent !important;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 3rem);">
    <div class="w-100">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-center py-4 bg-white">
                        <h4 class="fw-bold mb-1 text-dark">Selamat Datang</h4>
                        <div class="text-muted small">PAUD Teratai • Monitoring Perkembangan Anak</div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <div class="fw-semibold small mb-1">Gagal login:</div>
                                <ul class="mb-0 small ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control bg-light border-0 py-2"
                                        placeholder="nama@email.com"
                                        required
                                        autofocus
                                    >
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control bg-light border-0 py-2"
                                        placeholder="••••••••"
                                        required
                                    >
                                    <button class="btn bg-light border-0 py-2" type="button" id="togglePassword">
                                        <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p class="text-muted small">© {{ date('Y') }} PAUD Teratai. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon
            if (type === 'text') {
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    });
</script>
@endpush