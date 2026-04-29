<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pengabdian;
use App\Models\Pengajaran;
use App\Models\Penelitian;
use App\Models\Penunjang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PengajaranController extends Controller
{
    private array $semesterOptions = ['Ganjil', 'Genap'];

    public function index(): View
    {
        $user = auth()->user();
        $dosen = $user?->dosen;

        $pengajarans = $this->queryByRole(Pengajaran::query(), $user?->role, $dosen?->id)->latest()->get();
        $bukus = $this->queryByRole(Buku::query(), $user?->role, $dosen?->id)->latest()->get();
        $penelitians = $this->queryByRole(Penelitian::query(), $user?->role, $dosen?->id)->latest()->get();
        $pengabdians = $this->queryByRole(Pengabdian::query(), $user?->role, $dosen?->id)->latest()->get();
        $penunjangs = $this->queryByRole(Penunjang::query(), $user?->role, $dosen?->id)->latest()->get();

        return view('kinerja-saya.index', compact('pengajarans', 'bukus', 'penelitians', 'pengabdians', 'penunjangs'));
    }

    public function adminIndex(): View
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        return $this->index();
    }

    public function create(): View
    {
        return view('kinerja-saya.create', [
            'semesterOptions' => $this->semesterOptions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mata_kuliah' => ['required', 'string'],
            'sks' => ['required', 'numeric'],
            'semester' => ['required', Rule::in($this->semesterOptions)],
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

        return redirect()->route('kinerja-saya.index')->with('success', 'Data pengajaran berhasil ditambahkan.');
    }

    public function edit(Pengajaran $pengajaran): View
    {
        $this->authorizeOwnership($pengajaran);

        return view('kinerja-saya.edit', [
            'pengajaran' => $pengajaran,
            'semesterOptions' => $this->semesterOptions,
        ]);
    }

    public function update(Request $request, Pengajaran $pengajaran): RedirectResponse
    {
        $this->authorizeOwnership($pengajaran);

        $validated = $request->validate([
            'mata_kuliah' => ['required', 'string'],
            'sks' => ['required', 'numeric'],
            'semester' => ['required', Rule::in($this->semesterOptions)],
        ]);

        $pengajaran->update([
            'mata_kuliah' => $validated['mata_kuliah'],
            'sks' => $validated['sks'],
            'semester' => $validated['semester'],
            'status' => 'pending',
        ]);

        return redirect()->route('kinerja-saya.index')->with('success', 'Data pengajaran berhasil diperbarui.');
    }

    public function destroy(Pengajaran $pengajaran): RedirectResponse
    {
        $this->authorizeOwnership($pengajaran);

        $pengajaran->delete();

        return redirect()->route('kinerja-saya.index')->with('success', 'Data pengajaran berhasil dihapus.');
    }


    private function authorizeOwnership(Pengajaran $pengajaran): void
    {
        $dosenId = auth()->user()?->dosen?->id;

        abort_unless($dosenId && $pengajaran->dosen_id === $dosenId && $pengajaran->status === 'pending', 403);
    }

    private function queryByRole($query, ?string $role, ?int $dosenId)
    {
        if ($role === 'admin') {
            return $query;
        }

        return $dosenId ? $query->where('dosen_id', $dosenId) : $query->whereRaw('1=0');
    }
}
