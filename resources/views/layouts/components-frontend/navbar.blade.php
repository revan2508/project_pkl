<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    {{-- LOGO --}}
    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
      <h1 class="sitename">GoTugas</h1>
    </a>

    {{-- MENU --}}
    <nav id="navmenu" class="navmenu me-3">
      <ul>
        <li><a href="{{ url('/') }}" class="active">Beranda</a></li>
        <li><a href="{{ url('join') }}">Masuk Kelas</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    {{-- AUTH AREA --}}
    @if (Route::has('login'))
      <div class="d-flex align-items-center gap-3">

        @auth
          @php
            $notifikasi = \App\Models\Notifikasi::where('id_user', auth()->id())
              ->where('sudah_dibaca', false)
              ->latest()
              ->take(5)
              ->get();

            $jumlahNotif = $notifikasi->count();
          @endphp

          {{-- 🔔 NOTIFIKASI --}}
          <div class="dropdown">
            <a href="#" class="btn btn-outline-dark btn-sm position-relative"
               id="notifDropdown"
               data-bs-toggle="dropdown"
               aria-expanded="false">

              <i class="bi bi-bell"></i>

              @if($jumlahNotif > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  {{ $jumlahNotif }}
                </span>
              @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow"
                aria-labelledby="notifDropdown"
                style="width: 300px;">

              <li class="dropdown-header fw-bold text-center">
                Notifikasi
              </li>

              @forelse ($notifikasi as $notif)
                <li>
                  <form action="{{ route('notifikasi.dibaca', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-wrap">
                      <div class="fw-semibold">{{ $notif->judul }}</div>
                      <small class="text-muted">{{ $notif->pesan }}</small>
                    </button>
                  </form>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
              @empty
                <li class="text-center text-muted py-3">
                  Tidak ada notifikasi baru
                </li>
              @endforelse

              @if($jumlahNotif > 0)
                <li>
                  <form action="{{ route('notifikasi.dibacaSemua') }}" method="POST">
                    @csrf
                    <button class="dropdown-item text-center text-primary small">
                      Tandai semua dibaca
                    </button>
                  </form>
                </li>
              @endif
            </ul>
          </div>

          {{-- 👤 USER --}}
          <div class="dropdown">
            <a class="btn btn-outline-dark btn-sm dropdown-toggle"
               href="#"
               role="button"
               id="userDropdown"
               data-bs-toggle="dropdown"
               aria-expanded="false">
              {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>

        @else
          <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
            Log in
          </a>
        @endauth

      </div>
    @endif

  </div>
</header>
