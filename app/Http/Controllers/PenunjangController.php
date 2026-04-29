<?php

namespace App\Http\Controllers;

use App\Models\Penunjang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PenunjangController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string'],
            'file' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');

        Penunjang::create([...$validated, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);
        return redirect()->route('kinerja-saya.index', ['tab' => 'penunjang'])->with('success', 'Data penunjang berhasil ditambahkan.');
    }
}
