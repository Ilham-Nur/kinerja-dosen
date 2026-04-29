<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenelitianController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => ['required', Rule::in(['nasional', 'internasional'])],
            'judul' => ['required', 'string'],
            'tahun' => ['required', 'digits:4'],
            'sumber_biaya' => ['required', 'string'],
            'jumlah_biaya' => ['required', 'numeric'],
            'link' => ['nullable', 'string'],
            'file' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');

        Penelitian::create([...$validated, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);
        return redirect()->route('kinerja-saya.index', ['tab' => 'penelitian-'.$validated['tipe']])->with('success', 'Data penelitian berhasil ditambahkan.');
    }
}
