<aside id="sidebar" class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="fa-solid fa-layer-group"></i></div>
        <span class="sidebar-brand-name">AdminPanel</span>
    </div>

    <nav class="sidebar-nav" aria-label="Sidebar navigation">
        <div class="sidebar-section-label">Utama</div>
        <div class="sidebar-item">
            <a href="{{ route('dashboard.index') }}" class="sidebar-link active" data-page="index">
                <span class="sidebar-link-icon"><i class="fa-solid fa-house"></i></span>
                <span class="sidebar-link-label">Dashboard</span>
            </a>
        </div>

        <div class="sidebar-section-label">Akun</div>
        <div class="sidebar-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link" style="width: 100%; border: 0; background: transparent; text-align: left; cursor: pointer;">
                    <span class="sidebar-link-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                    <span class="sidebar-link-label">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name ?? '-' }}</div>
                <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role ?? '-') }}</div>
            </div>
        </div>
    </div>
</aside>
