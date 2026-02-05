<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSiswaController extends Controller
{
    public function edit()
    {
        $siswa = Auth::user()->siswa;
        return view('siswa.profil.edit', compact('siswa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nis'    => 'nullable|string|max:20',
            'kelas'  => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'foto'   => 'nullable|image|max:2048',
        ]);

        $siswa = Auth::user()->siswa;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_siswa', 'public');
            $siswa->foto = $path;
        }

        $siswa->nis    = $request->nis;
        $siswa->kelas  = $request->kelas;
        $siswa->alamat = $request->alamat;
        $siswa->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function show()
{
    $siswa = Auth::user()->siswa;
    return view('siswa.profil.show', compact('siswa'));
}

}
