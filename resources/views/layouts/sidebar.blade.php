<div class="col-md-3 col-lg-2 sidebar p-0">
    <div class="text-center py-4">
        <div class="mb-3 px-3">
            <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD" style="width: 100px; height: 100px; object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.2));">
        </div>
        <h5 class="text-white fw-bold mb-0" style="letter-spacing: 0.8px; font-size: 1.2rem;">PAUD Teratai</h5>
        <div class="mt-1">
            <span class="badge bg-white bg-opacity-10 text-white-50 fw-normal px-3 py-2 rounded-pill" style="font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.1);">
                Monitoring Perkembangan
            </span>
        </div>
    </div>
    
    <div class="px-3 mb-4">
        <div class="p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
            <div class="text-white-50 small mb-1">Login sebagai:</div>
            <div class="text-white fw-bold d-flex align-items-center">
                <i class="bi bi-person-circle me-2 fs-5"></i>
                <div class="text-truncate" style="max-width: 120px;">{{ Auth::user()->name }}</div>
            </div>
            <span class="badge {{ Auth::user()->role == 'guru' ? 'badge-guru' : 'badge-orangtua' }} mt-2 w-100">
                {{ Auth::user()->role === 'orang_tua' ? 'Orang Tua' : ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </div>
    
    <nav class="nav flex-column">
        @if(Auth::user()->role == 'guru')
            <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" 
               href="{{ route('guru.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('guru.murid*') ? 'active' : '' }}"
               href="{{ route('guru.murid.index') }}">
                <i class="bi bi-people"></i> Data Murid
            </a>
            <a class="nav-link {{ request()->routeIs('guru.kelas*') ? 'active' : '' }}"
               href="{{ route('guru.kelas.index') }}">
                <i class="bi bi-grid-3x3-gap"></i> Data Kelas
            </a>
            <a class="nav-link {{ request()->routeIs('guru.orangtua*') ? 'active' : '' }}" 
               href="{{ route('guru.orangtua.index') }}">
                <i class="bi bi-person-badge"></i> Data Orang Tua
            </a>
            <a class="nav-link {{ request()->routeIs('guru.perkembangan*') ? 'active' : '' }}" 
               href="{{ route('guru.perkembangan.index') }}">
                <i class="bi bi-graph-up"></i> Perkembangan Anak
            </a>
        @else
            <a class="nav-link {{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}" 
               href="{{ route('orangtua.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('orangtua.perkembangan*') ? 'active' : '' }}" 
               href="{{ route('orangtua.perkembangan.index') }}">
                <i class="bi bi-journal-text"></i> Perkembangan Anak
            </a>
        @endif
        
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>