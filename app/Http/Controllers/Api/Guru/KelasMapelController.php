<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasMapelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/guru/kelas/{id}/mapel
    public function index($id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())
            ->with('mapel')
            ->findOrFail($id);

        $mapel = Mapel::orderBy('nama_mapel')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'kelas' => $kelas,
                'mapel_tersedia' => $mapel,
                'mapel_terpilih' => $kelas->mapel
            ]
        ]);
    }

    // POST /api/guru/kelas/{id}/mapel
    public function store(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);

        $mapelIds = $this->getMapelIds($request);

        $kelas->mapel()->syncWithoutDetaching($mapelIds);

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil ditambahkan',
            'data' => $kelas->mapel()->get()
        ]);
    }

    // PUT /api/guru/kelas/{id}/mapel
    public function update(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);

        $mapelIds = $this->getMapelIds($request);

        $kelas->mapel()->sync($mapelIds);

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil diupdate (diganti semua)',
            'data' => $kelas->mapel()->get()
        ]);
    }

    // DELETE /api/guru/kelas/{id}/mapel
    public function destroy(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())->findOrFail($id);

        $mapelIds = $this->getMapelIds($request);

        $kelas->mapel()->detach($mapelIds);

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil dihapus',
            'data' => $kelas->mapel()->get()
        ]);
    }

    // 🔥 HELPER (ANTI ERROR)
    private function getMapelIds(Request $request)
    {
        // ambil dari body atau query (?mapel_id=1)
        $mapelIds = $request->input('mapel_id');

        if (!$mapelIds) {
            abort(response()->json([
                'message' => 'mapel_id wajib diisi'
            ], 422));
        }

        // ubah jadi array kalau single
        $mapelIds = is_array($mapelIds) ? $mapelIds : [$mapelIds];

        // validasi manual
        $invalid = Mapel::whereIn('id', $mapelIds)->pluck('id')->toArray();

        if (count($invalid) !== count($mapelIds)) {
            abort(response()->json([
                'message' => 'Ada mapel_id yang tidak valid'
            ], 422));
        }

        return $mapelIds;
    }
}
