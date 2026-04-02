<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Notifikasi;

class TugasController extends Controller
{
    public function index(Kelas $kelas)
    {
        $tugas = Tugas::with('mapel')
            ->where('kelas_id', $kelas->id)
            ->latest()
            ->get();

        return view('guru.tugas.index', compact('kelas', 'tugas'));
    }

    public function create(Kelas $kelas)
    {
        $kelas->load('mapel');
        return view('guru.tugas.create', compact('kelas'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mapel_id'  => 'required|exists:mapel,id',
            'judul'     => 'required',
            'perintah'  => 'required',
            'deskripsi' => 'required',
            // 🔥 VALIDASI DEADLINE (FIX)
            'deadline'  => 'required|date|after:now',
            'tipe'      => 'required|in:individu,kelompok',
        ]);

        $tugas = Tugas::create([
            'kelas_id'  => $kelas->id,
            'mapel_id'  => $request->mapel_id,
            'judul'     => $request->judul,
            'perintah'  => $request->perintah,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'tipe'      => $request->tipe,
        ]);

        foreach ($kelas->siswa as $siswa) {
            Notifikasi::create([
                'id_user' => $siswa->id,
                'jenis'   => 'tugas_baru',
                'judul'   => 'Tugas Baru',
                'pesan'   => 'Ada tugas baru di kelas ' . $kelas->nama_kelas,
                'url_aksi'=> route('siswa.tugas.show', $tugas->id),
            ]);
        }

        return redirect()
            ->route('guru.tugas.index', $kelas->id)
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Tugas $tugas)
    {
        $tugas->load('kelas', 'mapel');
        return view('guru.tugas.edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $request->validate([
            'judul'     => 'required',
            'perintah'  => 'required',
            'deskripsi' => 'required',
            // 🔥 VALIDASI DEADLINE (FIX)
            'deadline'  => 'required|date|after:now',
            'tipe'      => 'required|in:individu,kelompok',
        ]);

        $tugas->update($request->only([
            'judul','perintah','deskripsi','deadline','tipe'
        ]));

        return redirect()
            ->route('guru.tugas.index', $tugas->kelas_id)
            ->with('success', 'Tugas diperbarui');
    }

    public function lihatPengumpulan(Tugas $tugas)
    {
        $tugas->load('pengumpulan.siswa');
        return view('guru.tugas.pengumpulan', compact('tugas'));
    }

    public function beriNilai(Request $request, PengumpulanTugas $pengumpulan)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        $pengumpulan->update([
            'nilai' => $request->nilai,
            'status'=> 'dinilai'
        ]);

        return back();
    }

    public function pilihKelas()
    {
        $kelas = Kelas::where('guru_id', auth()->id())->get();
        return view('guru.tugas.pilih-kelas', compact('kelas'));
    }

    public function destroy(Tugas $tugas)
    {
        $kelasId = $tugas->kelas_id;
        $tugas->delete();

        return redirect()->route('guru.tugas.index', $kelasId);
    }
}
