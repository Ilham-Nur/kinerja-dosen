<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string'],
            'isbn' => ['nullable', 'string'],
            'tahun' => ['required', 'digits:4'],
            'sumber_biaya' => ['required', 'string'],
            'jumlah_biaya' => ['required', 'numeric'],
            'link' => ['nullable', 'string'],
            'file' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) {
            return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');
        }

        Buku::create([...$validated, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);

        return redirect()->route('kinerja-saya.index', ['tab' => 'pengajaran-buku'])->with('success', 'Data buku berhasil ditambahkan.');
    }
}
