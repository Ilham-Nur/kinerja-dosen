@extends('layouts.app')

@section('title', 'Approval Data Kinerja')

@section('content')
<main class="page-content approval-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Approval Data Kinerja</h1>
            <p class="page-header-subtitle">Review, filter, dan validasi seluruh data kinerja dosen.</p>
        </div>
    </div>

    <section class="card approval-filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('approval.index') }}" class="approval-filter-form" data-approval-filter>
                <div class="form-group">
                    <label for="type" class="form-label">Kategori</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach ($types as $key => $config)
                            <option value="{{ $key }}" @selected($selectedType === $key)>{{ $config['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Semua Status</option>
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="approval-filter-actions">
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    <a href="{{ route('approval.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </section>

    <section class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Pengajuan</div>
                <div class="card-subtitle">Nama dosen, kategori, judul/kegiatan, status, dan aksi review.</div>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper" style="border:0; box-shadow:none; border-radius:0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Dosen</th>
                            <th>Kategori</th>
                            <th>Judul / Nama Kegiatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $row)
                            <tr>
                                <td>{{ $row['lecturer'] }}</td>
                                <td>{{ $row['category'] }}</td>
                                <td>{{ $row['title'] }}</td>
                                <td><span class="badge status-{{ $row['status'] }}">{{ ucfirst($row['status']) }}</span></td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('approval.show', [$row['type'], $row['id']]) }}">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data yang sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection
