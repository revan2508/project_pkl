<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Daftar notif yeuh
     */
    public function index()
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())
            ->latest()
            ->paginate(10);

        return view('notifikasi.index', compact('notifikasi'));
    }

    /**
     * Jang nandaken ngges dibaca can
     */
    public function tandaiDibaca($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $notifikasi->update([
            'sudah_dibaca' => true
        ]);

        if ($notifikasi->url_aksi) {
            return redirect($notifikasi->url_aksi);
        }

        return back();
    }

    /**
     * Jang nandaken ges di baca
     */
    public function tandaiSemuaDibaca()
    {
        Notifikasi::where('id_user', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return back();
    }
}
