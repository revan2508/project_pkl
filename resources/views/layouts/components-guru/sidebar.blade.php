<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark border-end" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- SECTION --}}
                <div class="sb-sidenav-menu-heading text-uppercase small text-muted px-3">
                    Menu
                </div>

                {{-- DASHBOARD --}}
                <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
                   href="{{ route('guru.dashboard') }}">
                    <div class="sb-nav-link-icon text-muted">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    Dashboard
                </a>

                {{-- KELAS --}}
                <a class="nav-link {{ request()->routeIs('guru.kelas.*') ? 'active' : '' }}"
                   href="{{ route('guru.kelas.index') }}">
                    <div class="sb-nav-link-icon text-muted">
                        <i class="fas fa-school"></i>
                    </div>
                    Kelas
                </a>

                {{-- MAPEL --}}
                <a class="nav-link {{ request()->routeIs('guru.mapel.*') ? 'active' : '' }}"
                   href="{{ route('guru.mapel.index') }}">
                    <div class="sb-nav-link-icon text-muted">
                        <i class="fas fa-book"></i>
                    </div>
                    Mapel
                </a>

                {{-- TUGAS --}}
                <a class="nav-link {{ request()->routeIs('guru.tugas.*') ? 'active' : '' }}"
                   href="{{ route('guru.tugas.pilihKelas') }}">
                    <div class="sb-nav-link-icon text-muted">
                        <i class="fas fa-tasks"></i>
                    </div>
                    Tugas
                </a>

            </div>
        </div>

        {{-- FOOTER --}}
        <div class="sb-sidenav-footer border-top small text-muted">
            <div class="mb-1">Login sebagai</div>
            <div class="fw-semibold text-white">
                {{ Auth::user()->name }}
            </div>
        </div>
    </nav>
</div>
