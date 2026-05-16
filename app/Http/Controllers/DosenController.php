<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(): View
    {
        $dosens = Dosen::query()
            ->with('user')
            ->latest()
            ->get();

        return view('dosens.index', compact('dosens'));
    }

    public function create(): View
    {
        return view('dosens.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string'],
            'nuptk' => ['required', 'string', 'unique:dosens,nuptk', 'unique:users,username'],
            'jabatan_fungsional' => ['required', 'string'],
            'ikatan_kerja' => ['required', 'string'],
            'buat_akun' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $dosen = Dosen::create([
                'nama' => $validated['nama'],
                'nuptk' => $validated['nuptk'],
                'jabatan_fungsional' => $validated['jabatan_fungsional'],
                'ikatan_kerja' => $validated['ikatan_kerja'],
            ]);

            if ($request->boolean('buat_akun')) {
                $user = User::create([
                    'name' => $validated['nama'],
                    'username' => $validated['nuptk'],
                    'password' => bcrypt('123456'),
                    'role' => 'dosen',
                ]);

                $dosen->update([
                    'user_id' => $user->id,
                ]);
            }
        });

        return redirect()
            ->route('dosens.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen): View
    {
        $dosen->load('user');

        return view('dosens.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string'],
            'nuptk' => [
                'required',
                'string',
                Rule::unique('dosens', 'nuptk')->ignore($dosen->id),
                Rule::unique('users', 'username')->ignore($dosen->user_id),
            ],
            'jabatan_fungsional' => ['required', 'string'],
            'ikatan_kerja' => ['required', 'string'],
            'buat_akun' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($dosen, $validated, $request): void {
            $dosen->update([
                'nama' => $validated['nama'],
                'nuptk' => $validated['nuptk'],
                'jabatan_fungsional' => $validated['jabatan_fungsional'],
                'ikatan_kerja' => $validated['ikatan_kerja'],
            ]);

            if ($dosen->user) {
                $dosen->user->update([
                    'name' => $validated['nama'],
                    'username' => $validated['nuptk'],
                ]);

                return;
            }

            if ($request->boolean('buat_akun')) {
                $user = User::create([
                    'name' => $validated['nama'],
                    'username' => $validated['nuptk'],
                    'password' => '123456',
                    'role' => 'dosen',
                ]);

                $dosen->update([
                    'user_id' => $user->id,
                ]);
            }
        });

        return redirect()
            ->route('dosens.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        DB::transaction(function () use ($dosen): void {
            $user = $dosen->user;

            $dosen->delete();

            if ($user && $user->role === 'dosen') {
                $user->delete();
            }
        });

        return redirect()
            ->route('dosens.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}
