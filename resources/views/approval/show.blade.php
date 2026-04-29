@extends('layouts.app')

@section('title', 'Review Approval')

@section('content')
<div class="container">
    <h1>Review {{ $config['label'] }}</h1>

    <a href="{{ route('approval.index') }}" class="btn btn-secondary" style="margin-bottom: 16px;">Kembali</a>

    <div class="card" style="padding: 16px; margin-bottom: 16px;">
        <h3>Informasi Dosen</h3>
        <p><strong>Nama:</strong> {{ $record->dosen?->nama ?? '-' }}</p>
        <p><strong>NUPTK:</strong> {{ $record->dosen?->nuptk ?? '-' }}</p>
    </div>

    <div class="card" style="padding: 16px; margin-bottom: 16px;">
        <h3>Detail Data</h3>
        @foreach ($record->getAttributes() as $field => $value)
            <p>
                <strong>{{ str_replace('_', ' ', ucfirst($field)) }}:</strong>
                @if (in_array($field, ['file']) && $value)
                    <a href="{{ asset('storage/' . $value) }}" target="_blank">Lihat File</a>
                @else
                    {{ $value ?? '-' }}
                @endif
            </p>
        @endforeach
        <p><strong>Created By:</strong> {{ $record->creator?->name ?? '-' }}</p>
        <p><strong>Approved By:</strong> {{ $record->approver?->name ?? '-' }}</p>
    </div>

    <div style="display:flex; gap: 12px; flex-wrap: wrap;">
        <form method="POST" action="{{ route('approval.approve', [$type, $record->id]) }}">
            @csrf
            <button class="btn btn-primary" type="submit">Approve</button>
        </form>

        <form method="POST" action="{{ route('approval.reject', [$type, $record->id]) }}" style="min-width: 320px;">
            @csrf
            <label for="notes"><strong>Catatan Reject (wajib)</strong></label>
            <textarea name="notes" id="notes" rows="3" required>{{ old('notes') }}</textarea>
            <button class="btn btn-danger" type="submit" style="margin-top: 8px;">Reject</button>
        </form>
    </div>
</div>
@endsection
