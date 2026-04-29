<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard — AdminPanel')</title>
    <link rel="stylesheet" href="{{ asset('template/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <div id="pageLoader" class="page-loader">
        <div class="spinner spinner-lg"></div>
        <div class="page-loader-text">Memuat halaman…</div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <div id="confirmOverlay" class="modal-overlay">
        <div class="modal" role="dialog" aria-modal="true">
            <div class="modal-header">
                <div id="confirmIcon" class="modal-icon warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="modal-header-text">
                    <div id="confirmTitle" class="modal-title">Konfirmasi Tindakan</div>
                    <div class="modal-subtitle">Periksa kembali sebelum melanjutkan</div>
                </div>
            </div>
            <div id="confirmBody" class="modal-body">Tindakan ini tidak dapat dibatalkan.</div>
            <div class="modal-footer">
                <button id="confirmCancel" class="btn btn-secondary">Batal</button>
                <button id="confirmOk" class="btn btn-danger">Konfirmasi</button>
            </div>
        </div>
    </div>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <div class="layout">
        @include('partials.sidebar')

        <div id="mainContent" class="main-content">
            @include('partials.navbar')
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('template/app.js') }}"></script>
</body>
</html>
