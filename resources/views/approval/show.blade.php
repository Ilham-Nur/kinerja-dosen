@extends('layouts.app')

@section('title', 'Review Approval')

@section('content')
<main class="page-content approval-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Review {{ $config['label'] }}</h1>
            <p class="page-header-subtitle">Periksa detail data sebelum approve atau reject.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('approval.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <section class="card" style="margin-bottom: 20px;">
        <div class="card-header"><div class="card-title">Informasi Dosen</div></div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $record->dosen?->nama ?? '-' }}</p>
            <p><strong>NUPTK:</strong> {{ $record->dosen?->nuptk ?? '-' }}</p>
        </div>
    </section>

    <section class="card" style="margin-bottom: 20px;">
        <div class="card-header"><div class="card-title">Detail Data</div></div>
        <div class="card-body">
            @foreach ($record->getAttributes() as $field => $value)
                <p>
                    <strong>{{ str_replace('_', ' ', ucfirst($field)) }}:</strong>
                    @if ($field === 'file' && $value)
                        <a href="{{ asset('storage/' . $value) }}" target="_blank">Lihat File</a>
                    @else
                        {{ $value ?? '-' }}
                    @endif
                </p>
            @endforeach
            <p><strong>Created By:</strong> {{ $record->creator?->name ?? '-' }}</p>
            <p><strong>Approved By:</strong> {{ $record->approver?->name ?? '-' }}</p>
        </div>
    </section>

    <section class="card">
        <div class="card-header"><div class="card-title">Aksi Approval</div></div>
        <div class="card-body">
            <p style="margin-bottom: 14px;">
                <strong>Status Saat Ini:</strong>
                <span class="badge {{ $record->status === 'approved' ? 'badge-success' : ($record->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($record->status) }}</span>
            </p>

            @if ($record->status === 'pending')
                <div class="approval-action-layout">
                    <form method="POST" action="{{ route('approval.approve', [$type, $record->id]) }}">
                        @csrf
                        <button class="btn btn-success" type="submit">Approve</button>
                    </form>

                    <form method="POST" action="{{ route('approval.reject', [$type, $record->id]) }}" class="approval-reject-form">
                        @csrf
                        <label for="notes" class="form-label">Catatan Reject <span class="required">*</span></label>
                        <textarea name="notes" id="notes" rows="4" class="form-control" required>{{ old('notes') }}</textarea>
                        <button class="btn btn-danger" type="submit" style="margin-top: 10px;">Reject</button>
                    </form>
                </div>
            @else
                <p class="card-subtitle">Data ini sudah diproses, aksi approve/reject tidak tersedia lagi.</p>
            @endif
        </div>
    </section>
</main>
@endsection
