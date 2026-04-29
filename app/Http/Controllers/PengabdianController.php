<?php

namespace App\Http\Controllers;

use App\Models\Pengabdian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PengabdianController extends Controller
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
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $user = auth()->user();
        $dosen = $user?->dosen;
        if (! $dosen) return back()->withInput()->with('error', 'Data dosen tidak ditemukan untuk akun ini.');

        $filePath = $request->file('file')?->store('kinerja/pengabdian', 'public');

        Pengabdian::create([...$validated, 'file' => $filePath, 'dosen_id' => $dosen->id, 'status' => 'pending', 'created_by' => $user->id]);
        return redirect()->route('kinerja-saya.index', ['tab' => 'pengabdian-'.$validated['tipe']])->with('success', 'Data pengabdian berhasil ditambahkan.');
    }

    public function edit(Pengabdian $item): View
    {
        $this->authorizePendingOwnership($item);

        return view('kinerja-saya.edit-pengabdian', ['item' => $item]);
    }

    public function update(Request $request, Pengabdian $item): RedirectResponse
    {
        $this->authorizePendingOwnership($item);
        $validated = $request->validate(['tipe' => ['required','in:nasional,internasional'], 'judul' => ['required','string'], 'tahun' => ['required','digits:4'], 'sumber_biaya' => ['required','string'], 'jumlah_biaya' => ['required','numeric'], 'link' => ['nullable','string'], 'file' => ['nullable','file','mimes:pdf,doc,docx,jpg,jpeg,png','max:2048']]);
        if ($request->hasFile('file')) { $validated['file'] = $request->file('file')->store('kinerja/pengabdian', 'public'); }
        $validated['status'] = 'pending';
        $item->update($validated);
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Pengabdian $item): RedirectResponse
    {
        $this->authorizePendingOwnership($item);
        $item->delete();
        return redirect()->route('kinerja-saya.index')->with('success', 'Data berhasil dihapus.');
    }

    private function authorizePendingOwnership(Pengabdian $item): void
    {
        $dosenId = auth()->user()?->dosen?->id;
        abort_unless($dosenId && $item->dosen_id === $dosenId && $item->status === 'pending', 403);
    }

}
