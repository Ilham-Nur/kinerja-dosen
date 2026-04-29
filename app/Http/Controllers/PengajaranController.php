<?php

namespace App\Http\Controllers;

use App\Models\Pengajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajaranController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $dosen = $user?->dosen;

        $pengajarans = $dosen
            ? Pengajaran::query()
                ->where('dosen_id', $dosen->id)
                ->latest()
                ->get()
            : collect();

        return view('kinerja-saya.index', compact('pengajarans'));
    }

    public function create(): View
    {
        return view('kinerja-saya.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mata_kuliah' => ['required', 'string'],
            'sks' => ['required', 'numeric'],
            'semester' => ['required', 'string'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;

        if (! $dosen) {
            return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');
        }

        Pengajaran::create([
            'dosen_id' => $dosen->id,
            'mata_kuliah' => $validated['mata_kuliah'],
            'sks' => $validated['sks'],
            'semester' => $validated['semester'],
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        return redirect()
            ->route('kinerja-saya.index')
            ->with('success', 'Data pengajaran berhasil ditambahkan.');
    }
}
