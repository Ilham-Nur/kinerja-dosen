@extends('layouts.app')

@section('title', 'Approval Data Kinerja')

@section('content')
<div class="container">
    <h1>Approval Data Kinerja</h1>

    <form method="GET" action="{{ route('approval.index') }}" style="display:flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <div>
            <label for="type">Kategori</label>
            <select name="type" id="type">
                <option value="">Semua Kategori</option>
                @foreach ($types as $key => $config)
                    <option value="{{ $key }}" @selected($selectedType === $key)>{{ $config['label'] }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div style="align-self: end;">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card" style="overflow-x:auto;">
        <table class="table" style="width:100%;">
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
                        <td>{{ ucfirst($row['status']) }}</td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('approval.show', [$row['type'], $row['id']]) }}">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
