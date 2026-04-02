<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaTugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/siswa/kelas/{kelasId}/tugas
    // List semua tugas di kelas (hanya kelas yang sudah diikuti)
    public function index($kelasId)
    {
        $user = Auth::user();

        // Pastikan siswa memang ada di kelas ini
        $ikutKelas = $user->kelas()->where('kelas_id', $kelasId)->exists();

        if (!$ikutKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak terdaftar di kelas ini'
            ], 403);
        }

        $tugas = Tugas::with('mapel')
            ->where('kelas_id', $kelasId)
            ->latest()
            ->get()
            ->map(function ($t) use ($user) {
                // Cek sudah dikumpulkan atau belum
                $pengumpulan = PengumpulanTugas::where('tugas_id', $t->id)
                    ->where('siswa_id', $user->id)
                    ->first();

                $t->sudah_dikumpulkan = $pengumpulan ? true : false;
                $t->status_pengumpulan = $pengumpulan?->status ?? null;
                $t->nilai = $pengumpulan?->nilai ?? null;
                return $t;
            });

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    // GET /api/siswa/tugas/{id}
    // Detail 1 tugas
    public function show($id)
    {
        $user = Auth::user();

        $tugas = Tugas::with(['mapel', 'kelas'])->findOrFail($id);

        // Pastikan siswa ada di kelas ini
        $ikutKelas = $user->kelas()->where('kelas_id', $tugas->kelas_id)->exists();

        if (!$ikutKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses ke tugas ini'
            ], 403);
        }

        // Ambil pengumpulan milik siswa ini (kalau ada)
        $pengumpulan = PengumpulanTugas::where('tugas_id', $id)
            ->where('siswa_id', $user->id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'tugas'       => $tugas,
                'pengumpulan' => $pengumpulan,
            ]
        ]);
    }

    // POST /api/siswa/tugas/{id}/submit
    // Kumpulkan tugas
    public function submit(Request $request, $id)
    {
        $user = Auth::user();

        $tugas = Tugas::findOrFail($id);

        // Pastikan siswa ada di kelas ini
        $ikutKelas = $user->kelas()->where('kelas_id', $tugas->kelas_id)->exists();

        if (!$ikutKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses ke tugas ini'
            ], 403);
        }

        // Cek deadline
        if (now()->greaterThan($tugas->deadline)) {
            return response()->json([
                'success' => false,
                'message' => 'Deadline tugas sudah lewat'
            ], 422);
        }

        $request->validate([
            'file'    => 'required|file|max:10240', // max 10MB
            'catatan' => 'nullable|string|max:500',
        ], [
            'file.required' => 'File tugas wajib diupload',
            'file.max'      => 'Ukuran file maksimal 10MB',
        ]);

        $path = $request->file('file')->store('pengumpulan_tugas', 'public');

        // Kalau sudah pernah submit → update (revisi)
        $pengumpulan = PengumpulanTugas::updateOrCreate(
            [
                'tugas_id' => $id,
                'siswa_id' => $user->id,
            ],
            [
                'file'    => $path,
                'catatan' => $request->catatan,
                'status'  => 'dikirim',
                'nilai'   => null, // reset nilai kalau revisi
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dikumpulkan',
            'data'    => $pengumpulan
        ], 201);
    }

    // GET /api/siswa/tugas/{id}/submission
    // Lihat submission sendiri untuk 1 tugas
    public function mySubmission($id)
    {
        $user = Auth::user();

        $tugas = Tugas::findOrFail($id);

        // Pastikan siswa ada di kelas ini
        $ikutKelas = $user->kelas()->where('kelas_id', $tugas->kelas_id)->exists();

        if (!$ikutKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses ke tugas ini'
            ], 403);
        }

        $pengumpulan = PengumpulanTugas::where('tugas_id', $id)
            ->where('siswa_id', $user->id)
            ->first();

        if (!$pengumpulan) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada pengumpulan untuk tugas ini'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengumpulan
        ]);
    }

    // GET /api/siswa/tugas-saya
    // Semua tugas dari semua kelas yang diikuti + status pengumpulan
    public function tugasSaya()
    {
        $user = Auth::user();

        $kelasIds = $user->kelas()->pluck('kelas.id');

        $tugas = Tugas::with(['mapel', 'kelas'])
            ->whereIn('kelas_id', $kelasIds)
            ->latest()
            ->get()
            ->map(function ($t) use ($user) {
                $pengumpulan = PengumpulanTugas::where('tugas_id', $t->id)
                    ->where('siswa_id', $user->id)
                    ->first();

                $t->sudah_dikumpulkan  = $pengumpulan ? true : false;
                $t->status_pengumpulan = $pengumpulan?->status ?? null;
                $t->nilai              = $pengumpulan?->nilai ?? null;
                $t->sudah_lewat        = now()->greaterThan($t->deadline);
                return $t;
            });

        return response()->json([
            'success' => true,
            'data'    => $tugas
        ]);
    }
}