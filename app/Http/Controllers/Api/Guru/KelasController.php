<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // pastikan user login
    }

    // GET /api/guru/kelas
    public function index()
    {
        $userId = Auth::id();

        $kelas = Kelas::withCount('mapel')
            ->where('guru_id', $userId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'auth_id' => $userId,
            'data' => $kelas
        ]);
    }

    // POST /api/guru/kelas
    // Kalau nama_kelas sudah ada → update
    // Kalau belum ada → create baru
    public function store(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        // Cek apakah kelas dengan nama yang sama sudah ada untuk guru ini
        $kelas = Kelas::where('guru_id', $userId)
            ->where('nama_kelas', $request->nama_kelas)
            ->first();

        if ($kelas) {
            // Update data lama
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
            ]);

            $message = 'Kelas sudah ada, diupdate otomatis';
        } else {
            // Create baru
            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'kode_kelas' => strtoupper(Str::random(6)),
                'guru_id'    => $userId,
            ]);

            $message = 'Kelas berhasil ditambahkan';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $kelas
        ], 201);
    }

    // GET /api/guru/kelas/{id}
    public function show($id)
    {
        $kelas = Kelas::with('mapel')
            ->where('guru_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    // PUT /api/guru/kelas/{id}
    public function update(Request $request, $id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kelas', 'nama_kelas')
                    ->where('guru_id', Auth::id())
                    ->ignore($kelas->id),
            ],
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate',
            'data' => $kelas
        ]);
    }

    // DELETE /api/guru/kelas/{id}
    public function destroy($id)
    {
        $kelas = Kelas::where('guru_id', Auth::id())
            ->findOrFail($id);

        // detach relasi mapel
        $kelas->mapel()->detach();

        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }
}
