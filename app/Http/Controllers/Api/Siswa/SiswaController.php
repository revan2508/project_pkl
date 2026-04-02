<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/siswa/kelas
    // List semua kelas yang sudah diikuti siswa
    public function kelasSaya()
    {
        $kelas = Auth::user()
            ->kelas()
            ->with(['mapel', 'guru:id,name,email'])
            ->latest('kelas_siswa.created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    // GET /api/siswa/kelas/{id}
    // Detail kelas beserta tugas-tugasnya
    public function detailKelas($id)
    {
        $kelas = Auth::user()
            ->kelas()
            ->with(['mapel', 'guru:id,name,email'])
            ->where('kelas.id', $id)
            ->firstOrFail();

        // Ambil semua tugas di kelas ini
        $tugas = \App\Models\Tugas::with('mapel')
            ->where('kelas_id', $kelas->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'kelas' => $kelas,
                'tugas' => $tugas,
            ]
        ]);
    }

    // POST /api/siswa/join
    // Join kelas pakai kode_kelas
    public function joinKelas(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|string',
        ], [
            'kode_kelas.required' => 'Kode kelas wajib diisi',
        ]);

        $kelas = Kelas::where('kode_kelas', strtoupper($request->kode_kelas))->first();

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kelas tidak ditemukan'
            ], 404);
        }

        $user = Auth::user();

        // Cek sudah join belum
        $sudahJoin = $user->kelas()->where('kelas_id', $kelas->id)->exists();

        if ($sudahJoin) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah tergabung di kelas ini'
            ], 422);
        }

        // Langsung join (tanpa approval)
        $user->kelas()->attach($kelas->id);

        // Notif ke guru
        Notifikasi::create([
            'id_user'      => $kelas->guru_id,
            'jenis'        => 'siswa_join_kelas',
            'judul'        => 'Siswa Bergabung',
            'pesan'        => $user->name . ' bergabung ke kelas ' . $kelas->nama_kelas,
            'url_aksi'     => null,
            'data_tambahan' => json_encode([
                'kelas_id' => $kelas->id,
                'siswa_id' => $user->id,
            ]),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil bergabung ke kelas ' . $kelas->nama_kelas,
            'data'    => $kelas->load('mapel', 'guru:id,name,email'),
        ], 201);
    }

    // DELETE /api/siswa/kelas/{id}/keluar
    // Keluar dari kelas
    public function keluarKelas($id)
    {
        $user = Auth::user();

        $kelas = $user->kelas()->where('kelas_id', $id)->firstOrFail();

        $user->kelas()->detach($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil keluar dari kelas ' . $kelas->nama_kelas,
        ]);
    }
}