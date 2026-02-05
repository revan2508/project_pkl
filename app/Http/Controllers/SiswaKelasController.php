<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaKelasController extends Controller
{
    public function index()
    {
        $kelasSaya = Auth::user()
            ->kelas()
            ->with('mapel.tugas')
            ->get();

        return view('siswa.index', compact('kelasSaya'));
    }

    public function showFormJoin()
    {
        return view('siswa.join');
    }

    public function prosesJoin(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required'
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->firstOrFail();

        $user = Auth::user();

        if ($user->kelas()->where('kelas_id', $kelas->id)->exists()) {
            return back()->with('error', 'Kamu sudah tergabung di kelas ini.');
        }

        $user->kelas()->attach($kelas->id);

        Notifikasi::create([
            'id_user' => $kelas->guru_id,
            'jenis' => 'siswa_join_kelas',
            'judul' => 'Siswa Bergabung',
            'pesan' => $user->name . ' bergabung ke kelas ' . $kelas->nama_kelas,
            'url_aksi' => route('guru.kelas.index'),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Berhasil join kelas!');
    }

    public function show($id)
    {
        $kelas = Auth::user()
            ->kelas()
            ->with('mapel.tugas')
            ->where('kelas.id', $id)
            ->firstOrFail();
            
        $tugas = $kelas->mapel->flatMap->tugas;

        return view('siswa.kelas_detail', compact('kelas', 'tugas'));
    }
}
