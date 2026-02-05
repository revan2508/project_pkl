<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Permintaan_Join;
use Illuminate\Support\Facades\Auth;

class JoinKelasController extends Controller
{
    public function form()
    {
        return view('join');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required',
        ]);

        // cari kelas
        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();

        if (!$kelas) {
            return back()->withErrors([
                'kode_kelas' => 'Kode kelas tidak ditemukan'
            ]);
        }

        // ambil siswa login
        $siswa = Auth::user();

        // cegah spam request join
        $sudahAda = Permintaan_Join::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'pending')
            ->exists();

        if ($sudahAda) {
            return back()->withErrors([
                'kode_kelas' => 'Permintaan join sudah dikirim sebelumnya.'
            ]);
        }

        // simpan permintaan join
        Permintaan_Join::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id,
            'status'   => 'pending',
        ]);

        // Notif ka guru yeuh
        Notifikasi::create([
            'id_user' => $kelas->guru_id,
            'jenis' => 'permintaan_join',
            'judul' => 'Permintaan Join Kelas',
            'pesan' => $siswa->name.' mengajukan permintaan join ke kelas '.$kelas->nama_kelas,
            'url_aksi' => route('guru.permintaanJoin'),
            'data_tambahan' => [
                'id_kelas' => $kelas->id,
                'id_siswa' => $siswa->id,
            ],
        ]);

        return redirect()
            ->route('kelas.formJoin')
            ->with('success', 'Permintaan join telah dikirim dan menunggu persetujuan guru.');
    }
}
