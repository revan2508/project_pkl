<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/guru/kelas/{kelas}/tugas
    public function index($kelasId)
    {
        $kelas = Kelas::where('guru_id', Auth::id())
            ->findOrFail($kelasId);

        $tugas = Tugas::with('mapel')
            ->where('kelas_id', $kelas->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    // POST /api/guru/kelas/{kelas}/tugas
    public function store(Request $request, $kelasId)
    {
        $kelas = Kelas::where('guru_id', Auth::id())
            ->findOrFail($kelasId);

        $request->validate([
            'mapel_id'  => 'required|exists:mapel,id',
            'judul'     => 'required',
            'perintah'  => 'required',
            'deskripsi' => 'required',
            'deadline'  => 'required|date|after:now',
            'tipe'      => 'required|in:individu,kelompok',
        ]);

        $tugas = Tugas::create([
            'kelas_id'  => $kelas->id,
            'mapel_id'  => $request->mapel_id,
            'judul'     => $request->judul,
            'perintah'  => $request->perintah,
            'deskripsi' => $request->deskripsi,
            'deadline'  => Carbon::parse($request->deadline), // 🔥 FIX JAM
            'tipe'      => $request->tipe,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dibuat',
            'data' => $tugas
        ], 201);
    }

    // GET /api/guru/tugas/{id}
    public function show($id)
    {
        $tugas = Tugas::with('mapel', 'kelas')
            ->whereHas('kelas', function ($q) {
                $q->where('guru_id', Auth::id());
            })
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    // PUT /api/guru/tugas/{id}
    public function update(Request $request, $id)
    {
        $tugas = Tugas::whereHas('kelas', function ($q) {
                $q->where('guru_id', Auth::id());
            })
            ->findOrFail($id);

        $request->validate([
            'judul'     => 'required',
            'perintah'  => 'required',
            'deskripsi' => 'required',
            'deadline'  => 'required|date|after:now',
            'tipe'      => 'required|in:individu,kelompok',
        ]);

        $tugas->update([
            'judul'     => $request->judul,
            'perintah'  => $request->perintah,
            'deskripsi' => $request->deskripsi,
            'deadline'  => Carbon::parse($request->deadline), // 🔥 FIX JAM
            'tipe'      => $request->tipe,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diupdate',
            'data' => $tugas
        ]);
    }

    // DELETE /api/guru/tugas/{id}
    public function destroy($id)
    {
        $tugas = Tugas::whereHas('kelas', function ($q) {
                $q->where('guru_id', Auth::id());
            })
            ->findOrFail($id);

        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }
}
