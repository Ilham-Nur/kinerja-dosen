<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Dosen;
use App\Models\Pengabdian;
use App\Models\Pengajaran;
use App\Models\Penelitian;
use App\Models\Penunjang;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'dosen') {
            $dosenId = $user->dosen?->id;

            abort_unless($dosenId, 403, 'Data dosen tidak ditemukan.');

            $kategori = [
                'Pengajaran' => Pengajaran::where('dosen_id', $dosenId)->count(),
                'Buku' => Buku::where('dosen_id', $dosenId)->count(),
                'Penelitian' => Penelitian::where('dosen_id', $dosenId)->count(),
                'Pengabdian' => Pengabdian::where('dosen_id', $dosenId)->count(),
                'Penunjang' => Penunjang::where('dosen_id', $dosenId)->count(),
            ];

            $totalPending = $this->countByStatusForDosen($dosenId, 'pending');
            $totalApproved = $this->countByStatusForDosen($dosenId, 'approved');
            $totalRejected = $this->countByStatusForDosen($dosenId, 'rejected');
            $totalKinerja = array_sum($kategori);

            arsort($kategori);
            $kategoriTeratas = array_key_first($kategori);

            return view('dashboard.dashboard-dosen', [
                'kategori' => $kategori,
                'total_kinerja' => $totalKinerja,
                'total_pending' => $totalPending,
                'total_approved' => $totalApproved,
                'total_rejected' => $totalRejected,
                'kategori_teratas' => $kategoriTeratas,
            ]);
        }

        $kategori = [
            'Pengajaran' => Pengajaran::count(),
            'Buku' => Buku::count(),
            'Penelitian' => Penelitian::count(),
            'Pengabdian' => Pengabdian::count(),
            'Penunjang' => Penunjang::count(),
        ];

        $pendingPerKategori = [
            'Pengajaran' => Pengajaran::where('status', 'pending')->count(),
            'Buku' => Buku::where('status', 'pending')->count(),
            'Penelitian' => Penelitian::where('status', 'pending')->count(),
            'Pengabdian' => Pengabdian::where('status', 'pending')->count(),
            'Penunjang' => Penunjang::where('status', 'pending')->count(),
        ];

        $totalPending = array_sum($pendingPerKategori);
        $totalApproved = $this->countByStatusGlobal('approved');
        $totalRejected = $this->countByStatusGlobal('rejected');
        $totalSemuaKinerja = array_sum($kategori);

        arsort($kategori);
        arsort($pendingPerKategori);


        $topDosenKinerja = Dosen::query()
            ->withCount(['pengajarans', 'bukus', 'penelitians', 'pengabdians', 'penunjangs'])
            ->get()
            ->map(function ($dosen) {
                $dosen->total_kinerja = $dosen->pengajarans_count
                    + $dosen->bukus_count
                    + $dosen->penelitians_count
                    + $dosen->pengabdians_count
                    + $dosen->penunjangs_count;

                return $dosen;
            })
            ->sortByDesc('total_kinerja')
            ->take(10)
            ->values();

        return view('dashboard.dashboard-admin', [
            'kategori' => $kategori,
            'total_dosen' => Dosen::count(),
            'total_semua_kinerja' => $totalSemuaKinerja,
            'total_pending' => $totalPending,
            'total_approved' => $totalApproved,
            'total_rejected' => $totalRejected,
            'kategori_terbanyak' => array_key_first($kategori),
            'pending_tertinggi' => array_key_first($pendingPerKategori),
            'top_dosen_kinerja' => $topDosenKinerja,
        ]);
    }

    private function countByStatusForDosen(int $dosenId, string $status): int
    {
        return Pengajaran::where('dosen_id', $dosenId)->where('status', $status)->count()
            + Buku::where('dosen_id', $dosenId)->where('status', $status)->count()
            + Penelitian::where('dosen_id', $dosenId)->where('status', $status)->count()
            + Pengabdian::where('dosen_id', $dosenId)->where('status', $status)->count()
            + Penunjang::where('dosen_id', $dosenId)->where('status', $status)->count();
    }

    private function countByStatusGlobal(string $status): int
    {
        return Pengajaran::where('status', $status)->count()
            + Buku::where('status', $status)->count()
            + Penelitian::where('status', $status)->count()
            + Pengabdian::where('status', $status)->count()
            + Penunjang::where('status', $status)->count();
    }
}
