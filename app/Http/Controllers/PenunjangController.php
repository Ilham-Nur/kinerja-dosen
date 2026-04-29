<?php

namespace App\Http\Controllers;

use App\Models\Penunjang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenunjangController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');

        $filePath = $request->file('file')?->store('kinerja/penunjang', 'public');

        Penunjang::create([...$validated, 'file' => $filePath, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);
        return redirect()->route('kinerja-saya.index', ['tab' => 'penunjang'])->with('success', 'Data penunjang berhasil ditambahkan.');
    }

    public function edit(Penunjang $penunjang): View
    {
        $this->authorizePendingOwnership($penunjang);

        return view('kinerja-saya.edit-penunjang', ['item' => $penunjang]);
    }

    public function update(Request $request, Penunjang $penunjang): RedirectResponse
    {
        $this->authorizePendingOwnership($penunjang);
        $validated = $request->validate(['nama_kegiatan' => ['required','string'], 'file' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,png','max:2048']]);
        if ($request->hasFile('file')) { $validated['file'] = $request->file('file')->store('kinerja/penunjang', 'public'); }
        $validated['status'] = 'pending';
        $penunjang->update($validated);
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Penunjang $penunjang): RedirectResponse
    {
        $this->authorizePendingOwnership($penunjang);
        $penunjang->delete();
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil dihapus.');
    }

    private function authorizePendingOwnership(Penunjang $penunjang): void
    {
        $dosenId = auth()->user()?->dosen?->id;
        abort_unless($dosenId && $penunjang->dosen_id === $dosenId && $penunjang->status === 'pending', 403);
    }

}
