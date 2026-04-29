@extends('layouts.app')

@section('title', 'Kinerja Saya')

@section('content')
@php
    $activeSubTab = request('tab', 'pengajaran-mk');
    $activeMainTab = str_contains($activeSubTab, '-') ? explode('-', $activeSubTab)[0] : $activeSubTab;
@endphp

<main class="page-content">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Kinerja Saya</h1>
            <p class="page-header-subtitle">Kelola data kinerja dosen per kategori.</p>
        </div>
    </div>

    <section class="ks-window">
        <div class="ks-window-header">
            <div class="ks-main-tabs" role="tablist" aria-label="Kategori Kinerja">
                <button class="ks-tab-btn" data-main-tab="pengajaran">Pengajaran</button>
                <button class="ks-tab-btn" data-main-tab="penelitian">Penelitian</button>
                <button class="ks-tab-btn" data-main-tab="pengabdian">Pengabdian</button>
                <button class="ks-tab-btn" data-main-tab="penunjang">Penunjang</button>
            </div>
        </div>

        <div class="ks-window-body">
            <section class="ks-main-panel" id="panel-pengajaran">
                <div class="ks-sub-tabs" role="tablist">
                    <button class="ks-subtab-btn" data-sub-tab="pengajaran-mk">Mata Kuliah</button>
                    <button class="ks-subtab-btn" data-sub-tab="pengajaran-buku">Buku</button>
                </div>
                <div class="ks-sub-panel" id="sub-pengajaran-mk">@include('kinerja-saya.partials.form-pengajaran') @include('kinerja-saya.partials.table-pengajaran')</div>
                <div class="ks-sub-panel" id="sub-pengajaran-buku">@include('kinerja-saya.partials.form-buku') @include('kinerja-saya.partials.table-buku')</div>
            </section>

            <section class="ks-main-panel" id="panel-penelitian">
                <div class="ks-sub-tabs" role="tablist">
                    <button class="ks-subtab-btn" data-sub-tab="penelitian-nasional">Nasional</button>
                    <button class="ks-subtab-btn" data-sub-tab="penelitian-internasional">Internasional</button>
                </div>
                <div class="ks-sub-panel" id="sub-penelitian-nasional">@include('kinerja-saya.partials.form-penelitian', ['tipe' => 'nasional']) @include('kinerja-saya.partials.table-penelitian', ['items' => $penelitians->where('tipe', 'nasional')])</div>
                <div class="ks-sub-panel" id="sub-penelitian-internasional">@include('kinerja-saya.partials.form-penelitian', ['tipe' => 'internasional']) @include('kinerja-saya.partials.table-penelitian', ['items' => $penelitians->where('tipe', 'internasional')])</div>
            </section>

            <section class="ks-main-panel" id="panel-pengabdian">
                <div class="ks-sub-tabs" role="tablist">
                    <button class="ks-subtab-btn" data-sub-tab="pengabdian-nasional">Nasional</button>
                    <button class="ks-subtab-btn" data-sub-tab="pengabdian-internasional">Internasional</button>
                </div>
                <div class="ks-sub-panel" id="sub-pengabdian-nasional">@include('kinerja-saya.partials.form-pengabdian', ['tipe' => 'nasional']) @include('kinerja-saya.partials.table-pengabdian', ['items' => $pengabdians->where('tipe', 'nasional')])</div>
                <div class="ks-sub-panel" id="sub-pengabdian-internasional">@include('kinerja-saya.partials.form-pengabdian', ['tipe' => 'internasional']) @include('kinerja-saya.partials.table-pengabdian', ['items' => $pengabdians->where('tipe', 'internasional')])</div>
            </section>

            <section class="ks-main-panel" id="panel-penunjang">
                @include('kinerja-saya.partials.form-penunjang')
                @include('kinerja-saya.partials.table-penunjang')
            </section>
        </div>
    </section>
</main>

<style>
.ks-window{background:var(--bg-card);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow-sm);overflow:hidden}
.ks-window-header{background:linear-gradient(180deg,#f8fbff,#eaf1fb);border-bottom:1px solid #d5e2f3;padding:0 10px}
.ks-main-tabs{display:flex;gap:4px;overflow:auto;padding-top:8px}
.ks-tab-btn{border:1px solid transparent;border-bottom:none;background:transparent;padding:10px 14px;border-top-left-radius:10px;border-top-right-radius:10px;color:#334155;font-weight:600;cursor:pointer;white-space:nowrap}
.ks-tab-btn:hover{background:#eef4ff}
.ks-tab-btn.active{background:#fff;border-color:#cfdced;color:#0f172a;box-shadow:0 -1px 0 #fff inset}
.ks-window-body{padding:14px}
.ks-main-panel,.ks-sub-panel{display:none}
.ks-main-panel.active,.ks-sub-panel.active{display:block}
.ks-sub-tabs{display:flex;gap:8px;flex-wrap:wrap;padding:6px 0 12px}
.ks-subtab-btn{padding:7px 11px;border-radius:999px;border:1px solid #d3ddeb;background:#f8fbff;color:#334155;font-weight:600;cursor:pointer}
.ks-subtab-btn.active{background:var(--primary);color:#fff;border-color:var(--primary)}
@media (max-width: 768px){.ks-window-body{padding:10px}.ks-tab-btn{font-size:13px;padding:9px 12px}}
</style>

<script>
document.addEventListener('DOMContentLoaded',()=>{
    const activeMainTab = @json($activeMainTab);
    const activeSubTab = @json($activeSubTab);

    const mainButtons = [...document.querySelectorAll('.ks-tab-btn')];
    const mainPanels = [...document.querySelectorAll('.ks-main-panel')];
    const subButtons = [...document.querySelectorAll('.ks-subtab-btn')];
    const subPanels = [...document.querySelectorAll('.ks-sub-panel')];

    const showMain = (tab) => {
        mainButtons.forEach(btn => btn.classList.toggle('active', btn.dataset.mainTab === tab));
        mainPanels.forEach(panel => panel.classList.toggle('active', panel.id === `panel-${tab}`));
    };

    const showSub = (subTab) => {
        subButtons.forEach(btn => btn.classList.toggle('active', btn.dataset.subTab === subTab));
        subPanels.forEach(panel => panel.classList.toggle('active', panel.id === `sub-${subTab}`));
    };

    mainButtons.forEach(btn => btn.addEventListener('click', () => {
        const main = btn.dataset.mainTab;
        showMain(main);

        if (main === 'pengajaran') showSub('pengajaran-mk');
        if (main === 'penelitian') showSub('penelitian-nasional');
        if (main === 'pengabdian') showSub('pengabdian-nasional');
    }));

    subButtons.forEach(btn => btn.addEventListener('click', () => showSub(btn.dataset.subTab)));

    showMain(activeMainTab || 'pengajaran');
    showSub(activeSubTab || 'pengajaran-mk');
});
</script>
@include('kinerja-saya.partials.confirm-script')
@endsection
