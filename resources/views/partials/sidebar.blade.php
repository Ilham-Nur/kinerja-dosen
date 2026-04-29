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
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">BG</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">Boss Gatra</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>
