<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pengabdian;
use App\Models\Pengajaran;
use App\Models\Penelitian;
use App\Models\Penunjang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    private const TYPE_MAP = [
        'pengajaran' => [
            'model' => Pengajaran::class,
            'label' => 'Pengajaran',
            'title_field' => 'mata_kuliah',
        ],
        'buku' => [
            'model' => Buku::class,
            'label' => 'Buku',
            'title_field' => 'judul',
        ],
        'penelitian' => [
            'model' => Penelitian::class,
            'label' => 'Penelitian',
            'title_field' => 'judul',
        ],
        'pengabdian' => [
            'model' => Pengabdian::class,
            'label' => 'Pengabdian',
            'title_field' => 'judul',
        ],
        'penunjang' => [
            'model' => Penunjang::class,
            'label' => 'Penunjang',
            'title_field' => 'nama_kegiatan',
        ],
    ];

    public function index(Request $request): View
    {
        $this->ensureAdmin();

        $selectedType = $request->string('type')->toString();
        $selectedStatus = $request->string('status')->toString();

        $records = collect(self::TYPE_MAP)
            ->when($selectedType !== '', fn (Collection $types) => $types->only($selectedType))
            ->flatMap(function (array $config, string $type) use ($selectedStatus) {
                $query = $config['model']::query()->with('dosen');

                if ($selectedStatus !== '') {
                    $query->where('status', $selectedStatus);
                }

                return $query->latest()->get()->map(function (Model $item) use ($type, $config) {
                    return [
                        'id' => $item->id,
                        'type' => $type,
                        'category' => $config['label'],
                        'lecturer' => $item->dosen?->nama ?? '-',
                        'title' => $item->{$config['title_field']} ?? '-',
                        'status' => $item->status,
                    ];
                });
            })
            ->sortByDesc('id')
            ->values();

        return view('approval.index', [
            'records' => $records,
            'types' => self::TYPE_MAP,
            'selectedType' => $selectedType,
            'selectedStatus' => $selectedStatus,
            'statusOptions' => ['pending', 'approved', 'rejected'],
        ]);
    }

    public function show(string $type, int $id): View
    {
        $this->ensureAdmin();

        $config = $this->resolveType($type);
        $record = $config['model']::with(['dosen', 'creator', 'approver'])->findOrFail($id);

        return view('approval.show', compact('record', 'type', 'config'));
    }

    public function approve(string $type, int $id): RedirectResponse
    {
        $this->ensureAdmin();

        $record = $this->resolveType($type)['model']::findOrFail($id);

        $record->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => null,
        ]);

        return redirect()->route('approval.show', [$type, $id])->with('success', 'Data berhasil di-approve.');
    }

    public function reject(Request $request, string $type, int $id): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'notes' => ['required', 'string'],
        ]);

        $record = $this->resolveType($type)['model']::findOrFail($id);

        $record->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('approval.show', [$type, $id])->with('success', 'Data berhasil di-reject.');
    }

    private function resolveType(string $type): array
    {
        abort_unless(isset(self::TYPE_MAP[$type]), 404);

        return self::TYPE_MAP[$type];
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }
}
