<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaNotifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // GET /api/siswa/notifikasi
    // List semua notifikasi milik siswa ini
    public function index()
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())
            ->latest()
            ->paginate(15);

        $belumDibaca = Notifikasi::where('id_user', Auth::id())
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'success'      => true,
            'belum_dibaca' => $belumDibaca,
            'data'         => $notifikasi,
        ]);
    }

    // PUT /api/siswa/notifikasi/{id}/baca
    // Tandai 1 notifikasi sudah dibaca
    public function tandaiDibaca($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $notifikasi->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca',
            'data'    => $notifikasi,
        ]);
    }

    // PUT /api/siswa/notifikasi/baca-semua
    // Tandai semua notifikasi sudah dibaca
    public function tandaiSemuaDibaca()
    {
        $count = Notifikasi::where('id_user', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => $count . ' notifikasi ditandai sudah dibaca',
        ]);
    }
}