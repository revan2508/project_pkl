<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>GoTugas - Login</title>
  <link rel="shortcut icon" href="{{ asset('assets/backend/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/css/styles.css') }}" />

  <!-- Iconify & tsParticles -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>

  <style>
    body {
      background: #f1f8e9;
      font-family: 'Segoe UI', sans-serif;
      position: relative;
      overflow: hidden;
    }

    #particles-bg {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .card {
      border: none;
      border-radius: 1rem;
      background: #fff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .form-control {
      border-radius: 0.75rem;
    }

    .btn-success {
      border-radius: 999px;
      background-color: #4caf50;
      border: none;
    }

    .btn-success:hover {
      background-color: #43a047;
    }

    .iconify {
      background-color: #e8f5e9;
      padding: 12px;
      border-radius: 50%;
    }

    label {
      font-weight: 600;
      color: #424242;
    }

    .form-label {
      color: #616161;
    }

    .text-muted small {
      font-size: 0.85rem;
    }

    .text-success {
      color: #388e3c !important;
    }
  </style>
</head>

<body>
  <!-- Partikel -->
  <div id="particles-bg"></div>

  <div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-8 col-lg-5 col-xxl-4">
      <div class="card p-4">
        <div class="card-body">

          <!-- Header -->
          <div class="text-center mb-4">
            <iconify-icon icon="mdi:book-open-page-variant" width="48" height="48" class="iconify text-success"></iconify-icon>
            <h4 class="fw-bold mt-2 text-success mb-1">GoTugas</h4>
            <small class="text-muted">Selamat datang kembali</small>
          </div>

          @if(session('status'))
            <div class="alert alert-success text-center py-2">
              {{ session('status') }}
            </div>
          @endif

          <!-- Form Login -->
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') }}" required autofocus>
              @error('email')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                     name="password" required>
              @error('password')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-success fw-semibold">Login</button>
            </div>

            <!-- <div class="text-center">
              <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary small">
                Lupa password?
              </a>
            </div> -->
          </form>

        </div>
      </div>

      <div class="text-center mt-3 text-muted">
        <small>&copy; {{ date('Y') }} GoTugas. Oleh Revan Risaldi.</small>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/theme.js') }}"></script>

  <script>
    tsParticles.load("particles-bg", {
      fullScreen: false,
      background: { color: "#f1f8e9" },
      particles: {
        number: { value: 40 },
        color: { value: "#81c784" },
        shape: { type: "circle" },
        opacity: { value: 0.4 },
        size: { value: 4 },
        move: { enable: true, speed: 1 },
        links: { enable: true, color: "#c8e6c9", distance: 100, opacity: 0.3 }
      },
      detectRetina: true,
    });
  </script>
</body>
</html>
