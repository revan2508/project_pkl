<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileGuruController extends Controller
{
    public function edit()
    {
        $guru = Auth::user()->guru;
        return view('guru.profil.edit', compact('guru'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nip'   => 'nullable|string|max:20',
            'mapel' => 'nullable|string|max:100',
            'foto'  => 'nullable|image|max:2048',
        ]);

        $guru = Auth::user()->guru;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_guru', 'public');
            $guru->foto = $path;
        }

        $guru->nip   = $request->nip;
        $guru->mapel = $request->mapel;
        $guru->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function show()
{
    $guru = Auth::user()->guru;
    return view('guru.profil.show', compact('guru'));
}

}
