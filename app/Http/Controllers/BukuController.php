<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) {
            return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');
        }

        $filePath = $request->file('file')?->store('kinerja/buku', 'public');

        Buku::create([...$validated, 'file' => $filePath, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);

        return redirect()->route('kinerja-saya.index', ['tab' => 'pengajaran-buku'])->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku): View
    {
        $this->authorizePendingOwnership($buku);

        return view('kinerja-saya.edit-buku', ['item' => $buku]);
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $this->authorizePendingOwnership($buku);
        $validated = $request->validate(['judul' => ['required','string'], 'tahun' => ['required','digits:4'], 'sumber_biaya' => ['required','string'], 'jumlah_biaya' => ['required','numeric'], 'link' => ['nullable','string'], 'file' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,png','max:2048']]);
        if ($request->hasFile('file')) { $validated['file'] = $request->file('file')->store('kinerja/buku', 'public'); }
        $validated['status'] = 'pending';
        $buku->update($validated);
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        $this->authorizePendingOwnership($buku);
        $buku->delete();
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil dihapus.');
    }

    private function authorizePendingOwnership(Buku $buku): void
    {
        $dosenId = auth()->user()?->dosen?->id;
        abort_unless($dosenId && $buku->dosen_id === $dosenId && $buku->status === 'pending', 403);
    }

}
