<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Brand -->
    <a class="navbar-brand ps-3" href="{{ route('guru.dashboard') }}">
        Dashboard Guru
    </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="ms-auto"></div>

    <ul class="navbar-nav me-3 me-lg-4 align-items-center">

        {{-- 🔔 NOTIFIKASI --}}
        @php
            $notifikasiBelumDibaca = \App\Models\Notifikasi::where('id_user', auth()->id())
                ->where('sudah_dibaca', false)
                ->latest()
                ->take(5)
                ->get();

            $jumlahBelumDibaca = $notifikasiBelumDibaca->count();
        @endphp

        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" id="notifDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                @if($jumlahBelumDibaca > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $jumlahBelumDibaca }}
                    </span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark p-0"
                aria-labelledby="notifDropdown"
                style="width: 320px;">

                <li class="dropdown-header text-center fw-bold py-2">
                    Notifikasi
                </li>

                @forelse($notifikasiBelumDibaca as $notif)
                    <li>
                        <form action="{{ route('notifikasi.dibaca', $notif->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="dropdown-item text-wrap small py-2">
                                <div class="fw-bold">{{ $notif->judul }}</div>
                                <div class="text-muted small">
                                    {{ $notif->pesan }}
                                </div>
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider m-0"></li>
                @empty
                    <li class="text-center text-muted py-3">
                        Tidak ada notifikasi baru
                    </li>
                @endforelse

                @if($jumlahBelumDibaca > 0)
                    <li>
                        <form action="{{ route('notifikasi.dibacaSemua') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-center text-warning small">
                                Tandai semua dibaca
                            </button>
                        </form>
                    </li>
                @endif
            </ul>
        </li>

        {{-- 👤 USER --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#"
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item"
                                onclick="return confirm('Yakin ingin logout?')">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>

    </ul>
</nav>
