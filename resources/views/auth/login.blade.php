<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — AdminPanel</title>
  <link rel="stylesheet" href="{{ asset('template/style.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div id="pageLoader" class="page-loader">
    <div class="spinner spinner-lg"></div>
    <div class="page-loader-text">Loading…</div>
  </div>

  <div id="toastContainer" class="toast-container"></div>

  <div class="auth-page">
    <div class="auth-bg-shape"></div>

    <div class="auth-card">
      <div class="auth-logo">
        <div class="auth-logo-icon">
          <i class="fa-solid fa-layer-group"></i>
        </div>
        <span class="auth-logo-name">AdminPanel</span>
      </div>

      <div class="auth-title">Selamat datang kembali</div>
      <div class="auth-subtitle">Masukkan kredensial Anda untuk melanjutkan.</div>

      <form method="POST" action="{{ route('login.attempt') }}" id="loginForm">
        @csrf
        <div class="form-group">
          <label class="form-label" for="login">Username / Email <span class="required">*</span></label>
          <div class="input-group">
            <i class="fa-solid fa-user input-group-icon"></i>
            <input type="text" id="login" name="login" class="form-control" placeholder="Masukkan username atau email" autocomplete="username" value="{{ old('login') }}" required />
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Kata Sandi <span class="required">*</span></label>
          <div class="input-group" style="position:relative;">
            <i class="fa-solid fa-lock input-group-icon"></i>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="current-password" required style="padding-right: 42px;" />
            <button type="button" class="show-password-toggle" data-target="password" aria-label="Toggle password visibility">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-flex align-center justify-between mb-16" style="margin-bottom: 22px;">
          <label class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" />
            <span class="form-check-label">Ingat saya</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary w-full btn-lg" id="loginBtn">
          <i class="fa-solid fa-arrow-right-to-bracket"></i>
          Masuk
        </button>
      </form>
    </div>
  </div>

  <script src="{{ asset('template/app.js') }}"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function () {
      const btn = document.getElementById('loginBtn');
      btn.disabled = true;
      btn.innerHTML = '<div class="spinner spinner-white"></div> Memproses…';
    });

    @if ($errors->any())
      Toast.error('Login Gagal', @json($errors->first()));
    @endif

    @if (session('success'))
      Toast.success('Berhasil', @json(session('success')));
    @endif
  </script>
</body>
</html>
