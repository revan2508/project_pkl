<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function show($id)
    {
        $tugas = Tugas::with('pengumpulan')->findOrFail($id);
        return view('siswa.tugas_detail', compact('tugas'));
    }

    public function kumpulkan(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,docx,pdf,zip|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $tugas = Tugas::with('mapel.kelas')->findOrFail($id);

        if (now()->gt($tugas->deadline)) {
            return back()->with('error', 'Deadline sudah lewat.');
        }

        // ✅ AMBIL KELAS PERTAMA (BUKAN COLLECTION)
        $kelas = $tugas->mapel->kelas->first();

        if (!$kelas) {
            return back()->with('error', 'Kelas tidak ditemukan.');
        }

        $path = $request->file('file')->store('tugas_siswa', 'public');

        $pengumpulan = PengumpulanTugas::create([
            'tugas_id' => $tugas->id,
            'siswa_id' => Auth::id(),
            'file' => $path,
            'catatan' => $request->catatan,
            'status' => 'dikirim',
        ]);

        Notifikasi::create([
            'id_user' => $kelas->guru_id,
            'jenis' => 'tugas_dikumpulkan',
            'judul' => 'Tugas Dikumpulkan',
            'pesan' => Auth::user()->name.' mengumpulkan tugas '.$tugas->judul,
            'url_aksi' => route('guru.tugas.pengumpulan', $tugas->id),
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function editPengumpulan($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        abort_if($pengumpulan->siswa_id !== Auth::id(), 403);

        return view('siswa.tugas_edit', compact('pengumpulan'));
    }

    public function updatePengumpulan(Request $request, $id)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:jpg,jpeg,png,docx,pdf,zip|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $pengumpulan = PengumpulanTugas::with('tugas.mapel.kelas')->findOrFail($id);
        abort_if($pengumpulan->siswa_id !== Auth::id(), 403);

        if ($request->hasFile('file')) {
            Storage::delete('public/'.$pengumpulan->file);
            $pengumpulan->file = $request->file('file')->store('tugas_siswa', 'public');
        }

        $pengumpulan->catatan = $request->catatan;
        $pengumpulan->save();

        $kelas = $pengumpulan->tugas->mapel->kelas->first();

        if ($kelas) {
            Notifikasi::create([
                'id_user' => $kelas->guru_id,
                'jenis' => 'tugas_diupdate',
                'judul' => 'Pengumpulan Diperbarui',
                'pesan' => Auth::user()->name.' memperbarui pengumpulan tugas.',
            ]);
        }

        return redirect()
            ->route('siswa.tugas.show', $pengumpulan->tugas_id)
            ->with('success', 'Pengumpulan berhasil diperbarui.');
    }

    public function destroyPengumpulan($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        abort_if($pengumpulan->siswa_id !== Auth::id(), 403);

        Storage::delete('public/'.$pengumpulan->file);
        $pengumpulan->delete();

        return redirect()
            ->route('siswa.tugas.show', $pengumpulan->tugas_id)
            ->with('success', 'Pengumpulan dibatalkan.');
    }
}
