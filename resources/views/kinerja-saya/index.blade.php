@extends('layouts.app')

@section('title', 'Kinerja Saya')

@section('content')
@php
$tab = request('tab', 'pengajaran-mk');
@endphp
<main class="page-content">
    <h1 class="page-header-title">Kinerja Saya</h1>

    <div class="tabs">
        <button class="tab-btn" data-tab="pengajaran">Pengajaran</button>
        <button class="tab-btn" data-tab="penelitian">Penelitian</button>
        <button class="tab-btn" data-tab="pengabdian">Pengabdian</button>
        <button class="tab-btn" data-tab="penunjang">Penunjang</button>
    </div>

    <section class="tab-panel" id="panel-pengajaran">
        <div class="subtabs"><button class="subtab-btn" data-subtab="pengajaran-mk">Mata Kuliah</button><button class="subtab-btn" data-subtab="pengajaran-buku">Buku</button></div>
        <div class="subtab-panel" id="sub-pengajaran-mk">
            @include('kinerja-saya.partials.form-pengajaran')
            @include('kinerja-saya.partials.table-pengajaran')
        </div>
        <div class="subtab-panel" id="sub-pengajaran-buku">
            @include('kinerja-saya.partials.form-buku')
            @include('kinerja-saya.partials.table-buku')
        </div>
    </section>

    <section class="tab-panel" id="panel-penelitian">
        <div class="subtabs"><button class="subtab-btn" data-subtab="penelitian-nasional">Nasional</button><button class="subtab-btn" data-subtab="penelitian-internasional">Internasional</button></div>
        <div class="subtab-panel" id="sub-penelitian-nasional">@include('kinerja-saya.partials.form-penelitian',['tipe'=>'nasional']) @include('kinerja-saya.partials.table-penelitian',['items'=>$penelitians->where('tipe','nasional')])</div>
        <div class="subtab-panel" id="sub-penelitian-internasional">@include('kinerja-saya.partials.form-penelitian',['tipe'=>'internasional']) @include('kinerja-saya.partials.table-penelitian',['items'=>$penelitians->where('tipe','internasional')])</div>
    </section>

    <section class="tab-panel" id="panel-pengabdian">
        <div class="subtabs"><button class="subtab-btn" data-subtab="pengabdian-nasional">Nasional</button><button class="subtab-btn" data-subtab="pengabdian-internasional">Internasional</button></div>
        <div class="subtab-panel" id="sub-pengabdian-nasional">@include('kinerja-saya.partials.form-pengabdian',['tipe'=>'nasional']) @include('kinerja-saya.partials.table-pengabdian',['items'=>$pengabdians->where('tipe','nasional')])</div>
        <div class="subtab-panel" id="sub-pengabdian-internasional">@include('kinerja-saya.partials.form-pengabdian',['tipe'=>'internasional']) @include('kinerja-saya.partials.table-pengabdian',['items'=>$pengabdians->where('tipe','internasional')])</div>
    </section>

    <section class="tab-panel" id="panel-penunjang">
        @include('kinerja-saya.partials.form-penunjang')
        @include('kinerja-saya.partials.table-penunjang')
    </section>
</main>

<style>.tabs,.subtabs{display:flex;gap:8px;flex-wrap:wrap;margin:12px 0}.tab-btn,.subtab-btn{padding:8px 12px;border:1px solid #ccc;border-radius:8px;background:#fff}.active{background:#2563eb;color:#fff;border-color:#2563eb}.tab-panel,.subtab-panel{display:none}.tab-panel.active,.subtab-panel.active{display:block}.card{background:#fff;border:1px solid #ddd;border-radius:10px;padding:12px;margin:12px 0}.table{width:100%}</style>
<script>
const activeSub='{{ $tab }}';
function activateTop(top){document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));document.querySelector('#panel-'+top)?.classList.add('active');document.querySelectorAll('.tab-btn').forEach(b=>b.classList.toggle('active',b.dataset.tab===top));}
function activateSub(sub){document.querySelectorAll('.subtab-panel').forEach(p=>p.classList.remove('active'));document.querySelector('#sub-'+sub)?.classList.add('active');document.querySelectorAll('.subtab-btn').forEach(b=>b.classList.toggle('active',b.dataset.subtab===sub));}
document.querySelectorAll('.tab-btn').forEach(b=>b.onclick=()=>activateTop(b.dataset.tab));document.querySelectorAll('.subtab-btn').forEach(b=>b.onclick=()=>activateSub(b.dataset.subtab));
activateTop(activeSub.split('-')[0]);activateSub(activeSub);
</script>
@endsection
